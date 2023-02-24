<?php

namespace App\Services;

use App\Actions\Links\ProductFloor as LinksProductFloor;
use App\Actions\Links\ProductPoint as LinksProductPoint;
use App\Actions\Links\ProductTask as LinksProductTask;
use App\Actions\Other\GetProductIdByArticle;
use App\Actions\ResponsePrepare\Product as ResponsePrepareProduct;
use App\Models\Category as ModelsCategory;
use App\Models\Product as ModelsProduct;
use App\Models\ProductPoint;
use Exception;

class Product
{
  public function index(string | null $search)
  {
    $products = ModelsProduct::select(
      'id',
      'article',
      'title',
      'author',
      'year_of_publication',
      'number',
      'year_of_printing',
      'printing_house',
      'publishing_house',
      'category_id'
    )
      ->addSelect(['category_title' => ModelsCategory::select('title')->whereColumn('id', 'category_id')]);

    if ($search) {
      $searchField = '%' . $search . '%';
      $products = $products->where('article', 'like', $searchField)
                          ->orWhere('title', 'like', $searchField)
                          ->orWhere('author', 'like', $searchField)
                          ->orWhere('year_of_publication', 'like', $searchField)
                          ->orWhere('number', 'like', $searchField)
                          ->orWhere('year_of_printing', 'like', $searchField)
                          ->orWhere('printing_house', 'like', $searchField)
                          ->orWhere('publishing_house', 'like', $searchField)
                          ->get();
    } else {
      $products = $products->get();
    }

    return (new ResponsePrepareProduct())($products);
  }

    public function show(int $productId)
    {
      $product = ModelsProduct::select(
        'id',
        'article',
        'title',
        'author',
        'year_of_publication',
        'number',
        'year_of_printing',
        'printing_house',
        'publishing_house',
        'category_id'
      )
        ->addSelect(['category_title' => ModelsCategory::select('title')->whereColumn('id', 'category_id')])
        ->addSelect(['point_id' => ProductPoint::select('point_id')->whereColumn('product_id', 'id')->limit(1)])
        ->where('id', $productId)
        ->first();

      return (new ResponsePrepareProduct())->oneProduct($product);
    }

  public function store(
    array $fields,
    int $userId,
    int $pointId,
  ) {
    $dateYearOfPrinting = strtotime($fields['yearOfPrinting']['value']);
    $formattedYearOfPrinting = date('Y-m-d', $dateYearOfPrinting);

    $product = new ModelsProduct();
    $product->article = $fields['article']['value'];
    $product->title = $fields['title']['value'];
    $product->author = $fields['author']['value'];
    $product->year_of_publication = $fields['yearOfPublication']['value'];
    $product->number = $fields['number']['value'];
    $product->year_of_printing = $formattedYearOfPrinting;
    $product->printing_house = $fields['printingHouse']['value'];
    $product->publishing_house = $fields['publishingHouse']['value'];
    $product->user_id = $userId;
    $product->category_id = $fields['categoryId']['value'];

    $product->save();

    (new LinksProductPoint())->add([$product->id], [$pointId]);
  }

  public function update(
    array $fields,
    int $userId,
    int $pointId,
  ) {
    $productId = $fields['id']['value'];

    $dateYearOfPrinting = strtotime($fields['yearOfPrinting']['value']);
    $formattedYearOfPrinting = date('Y-m-d', $dateYearOfPrinting);

    $product = ModelsProduct::where('id', $productId)->first();
    $product->article = $fields['article']['value'];
    $product->title = $fields['title']['value'];
    $product->author = $fields['author']['value'];
    $product->year_of_publication = $fields['yearOfPublication']['value'];
    $product->number = $fields['number']['value'];
    $product->year_of_printing = $formattedYearOfPrinting;
    $product->printing_house = $fields['printingHouse']['value'];
    $product->publishing_house = $fields['publishingHouse']['value'];
    $product->user_id = $userId;
    $product->category_id = $fields['categoryId']['value'];

    $product->save();

    $linksProductPoint = new LinksProductPoint();

    $linksProductPoint->deleteByProductIds([$productId]);
    $productId = (new GetProductIdByArticle())($fields['article']['value']);
    $linksProductPoint->add([$productId], [$pointId]);
  }

  public function destroy(array $productIds)
  {
    $linksProductTask = new LinksProductTask();
    $productsTasks = $linksProductTask->getByProductsIds($productIds);
    if ($productsTasks->count() > 0) {
      $tasksString = $productsTasks->implode('task_id', ', ');
      throw new Exception('Нельзя удалить продукт с которым связаны задачи: ' . $tasksString);
    }
    $linksProductTask->deleteByProductIds($productIds);
    (new LinksProductFloor())->deleteByProductIds($productIds);
    (new LinksProductPoint())->deleteByProductIds($productIds);
    ModelsProduct::whereIn('id', $productIds)->delete();
  }

  public function markAsMoved(int $productId)
  {
    (new LinksProductTask())->deleteByProductIds([$productId]);
    (new LinksProductPoint())->deleteByProductIds([$productId]);
    (new LinksProductFloor())->setPositionAsActual($productId);
  }
}
