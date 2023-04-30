<?php

namespace App\Services;

use App\Actions\Links\ProductFloor as LinksProductFloor;
use App\Actions\Links\ProductPoint as LinksProductPoint;
use App\Actions\Links\ProductTask as LinksProductTask;
use App\Actions\Other\GetProductIdByArticle;
use App\Actions\ResponsePrepare\Product as ResponsePrepareProduct;
use App\Models\Audience as ModelsAudience;
use App\Models\Book as ModelsBook;
use App\Models\Magazine as ModelsMagazine;
use App\Models\Category as ModelsCategory;
use App\Models\Product as ModelsProduct;
use App\Models\ProductPoint;
use App\Models\ProductType as ModelsProductType;
use App\Models\Regularity as ModelsRegularity;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Product
{
  public function index(string | null $search)
  {
    $products = ModelsProduct::select(
      'id',
      'article',
      'title',
      'number',
      'image_url',
      'note',
      'category_id',
      'product_type_id'
    )
      ->addSelect(['category_alias' => ModelsCategory::select('alias')->whereColumn('id', 'category_id')])
      ->addSelect(['type_alias' => ModelsProductType::select('alias')->whereColumn('id', 'product_type_id')]);


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

    $productsWithAddInfo = [];
    foreach ($products as $product) {
      switch ($product['product_type_id']) {
        case 1:
          $additionalInformation = ModelsBook::select(
            'product_id',
            'author',
            'year_of_publication',
            'year_of_printing',
            'printing_house',
            'publishing_house'
          )->where('product_id', $product->id)->first();

          array_push($productsWithAddInfo, array_merge($product->toArray(), $additionalInformation->toArray()));
          break;
        case 2:
          $additionalInformation = ModelsMagazine::select(
            'product_id',
            'printing_house',
            'publishing_house',
            'date_of_printing',
            'regularity_id',
            'audience_id',
          )
            ->addSelect(['regularity_alias' => ModelsRegularity::select('alias')->whereColumn('id', 'regularity_id')])
            ->addSelect(['audience_alias' => ModelsAudience::select('alias')->whereColumn('id', 'audience_id')])
            ->where('product_id', $product->id)->first();

          array_push($productsWithAddInfo, array_merge($product->toArray(), $additionalInformation->toArray()));
          break;
        default:
          array_push($productsWithAddInfo, $product->toArray());
      }
    }

    return (new ResponsePrepareProduct())($productsWithAddInfo);
  }

  public function show(int $productId)
  {

    $product = ModelsProduct::select(
      'id',
      'article',
      'title',
      'number',
      'image_url',
      'note',
      'category_id',
      'product_type_id'
    )
      ->addSelect(['category_alias' => ModelsCategory::select('alias')->whereColumn('id', 'category_id')])
      ->addSelect(['type_alias' => ModelsProductType::select('alias')->whereColumn('id', 'product_type_id')])
      ->addSelect(['point_id' => ProductPoint::select('point_id')->whereColumn('product_id', 'id')->limit(1)])
      ->where('id', $productId)
      ->first()
      ->toArray();

    switch ($product['product_type_id']) {
      case 1:
        $additionalInformation = ModelsBook::select(
          'product_id',
          'author',
          'year_of_publication',
          'year_of_printing',
          'printing_house',
          'publishing_house'
        )->where('product_id', $product['id'])
          ->first()
          ->toArray();

        $product = array_merge($product, $additionalInformation);
        break;
      case 2:
        $additionalInformation = ModelsMagazine::select(
          'product_id',
          'printing_house',
          'publishing_house',
          'date_of_printing',
          'regularity_id',
          'audience_id',
        )
          ->addSelect(['regularity_alias' => ModelsRegularity::select('alias')->whereColumn('id', 'regularity_id')])
          ->addSelect(['audience_alias' => ModelsAudience::select('alias')->whereColumn('id', 'audience_id')])
          ->where('product_id', $product['id'])
          ->first()
          ->toArray();

        $product = array_merge($product, $additionalInformation);
        break;
    }


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

  public function addImage(int $id, string $article, UploadedFile $file)
  {
    $fileName = Storage::putFile('products', $file);

    $product = ModelsProduct::where('id', $id)->orWhere('article', $article)->first();
    $lastImageUrl = $product->image_url;
    $product->image_url = $fileName;
    $product->save();

    if ($lastImageUrl) {
      Storage::delete($lastImageUrl);
    }
  }

  public function markAsMoved(int $productId)
  {
    (new LinksProductTask())->deleteByProductIds([$productId]);
    (new LinksProductPoint())->deleteByProductIds([$productId]);
    (new LinksProductFloor())->setPositionAsActual($productId);
  }
}
