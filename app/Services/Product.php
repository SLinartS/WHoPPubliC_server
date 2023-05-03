<?php

namespace App\Services;

use App\Actions\Links\ProductFloor as LinksProductFloor;
use App\Actions\Links\ProductPoint as LinksProductPoint;
use App\Actions\Links\ProductTask as LinksProductTask;
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
    $searchField = null;
    if ($search) {
      $searchField = '%' . $search . '%';
    }

    $products = ModelsProduct::join('product_types', 'product_types.id', 'products.type_id')
      ->join('categories', 'categories.id', 'products.category_id')
      ->select(
        'products.id',
        'products.article',
        'products.title',
        'products.number',
        'products.image_url',
        'products.note',
        'products.category_id',
        'products.type_id',
        'categories.alias as category_alias',
        'product_types.alias as type_alias',
      );

    if ($searchField) {
      $products = $products->where('article', 'like', $searchField)
        ->orWhere('products.title', 'like', $searchField)
        ->orWhere('products.number', 'like', $searchField)
        ->orWhere('products.note', 'like', $searchField)
        ->orWhere('categories.alias', 'like', $searchField)
        ->orWhere('product_types.alias', 'like', $searchField)
        ->get();
    } else {
      $products = $products->get();
    }

    $productsWithAddInfo = [];
    foreach ($products as $product) {
      switch ($product['type_id']) {
        case 1:
          $additionalInformation = ModelsBook::select(
            'product_id',
            'author',
            'year_of_publication',
            'year_of_printing',
            'printing_house',
            'publishing_house'
          )->where('product_id', $product->id);

          if ($searchField) {
            $additionalInformation->orWhere('author', 'like', $searchField)
              ->orWhere('year_of_publication', 'like', $searchField)
              ->orWhere('year_of_printing', 'like', $searchField)
              ->orWhere('printing_house', 'like', $searchField)
              ->orWhere('publishing_house', 'like', $searchField);
          }

          $additionalInformation = $additionalInformation->first();

          if ($additionalInformation) {
            array_push($productsWithAddInfo, array_merge($product->toArray(), $additionalInformation->toArray()));
          }
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
            ->where('product_id', $product->id);

          if ($searchField) {
            $additionalInformation->orWhere('printing_house', 'like', $searchField)
              ->orWhere('publishing_house', 'like', $searchField)
              ->orWhere('date_of_printing', 'like', $searchField)
              ->orWhere('regularity_id', 'like', $searchField)
              ->orWhere('audience_id', 'like', $searchField);
          }

          $additionalInformation = $additionalInformation->first();

          if ($additionalInformation) {
            array_push($productsWithAddInfo, array_merge($product->toArray(), $additionalInformation->toArray()));
          }
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
      'type_id'
    )
      ->addSelect(['category_alias' => ModelsCategory::select('alias')->whereColumn('id', 'category_id')])
      ->addSelect(['type_alias' => ModelsProductType::select('alias')->whereColumn('id', 'type_id')])
      ->addSelect(['point_id' => ProductPoint::select('point_id')->whereColumn('product_id', 'id')->limit(1)])
      ->where('id', $productId)
      ->first()
      ->toArray();

    switch ($product['type_id']) {
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
    $typeId = $fields['typeId']['value'];

    $product = new ModelsProduct();
    $product->article = $fields['article']['value'];
    $product->title = $fields['title']['value'];
    $product->number = $fields['number']['value'];
    $product->note = $fields['note']['value'];;
    $product->type_id = $fields['typeId']['value'];
    $product->user_id = $userId;
    $product->category_id = $fields['categoryId']['value'];

    $product->save();

    (new LinksProductPoint())->add([$product->id], [$pointId]);

    switch ($typeId) {
      case 1:
        $book = new ModelsBook();

        $book->author = $fields['author']['value'];
        $book->year_of_publication = $fields['yearOfPublication']['value'];
        $book->year_of_printing = $fields['yearOfPrinting']['value'];
        $book->printing_house = $fields['printingHouse']['value'];
        $book->publishing_house = $fields['publishingHouse']['value'];
        $book->product_id = $product->id;

        $book->save();
        break;
      case 2:
        $dateYearOfPrinting = strtotime($fields['dateOfPrinting']['value']);
        $formattedYearOfPrinting = date('Y-m-d', $dateYearOfPrinting);

        $magazine = new ModelsMagazine();

        $magazine->date_of_printing = $formattedYearOfPrinting;
        $magazine->printing_house = $fields['printingHouse']['value'];
        $magazine->publishing_house = $fields['publishingHouse']['value'];
        $magazine->regularity_id = $fields['regularityId']['value'];
        $magazine->audience_id = $fields['audienceId']['value'];
        $magazine->product_id = $product->id;

        $magazine->save();
        break;
      default:
    }
  }

  public function update(
    array $fields,
    int $userId,
    int $pointId,
  ) {
    $productId = $fields['id']['value'];
    $typeId = $fields['typeId']['value'];

    $product = ModelsProduct::where('id', $productId)->first();
    $product->article = $fields['article']['value'];
    $product->title = $fields['title']['value'];
    $product->number = $fields['number']['value'];
    $product->note = $fields['note']['value'];;
    $product->type_id = $fields['typeId']['value'];
    $product->user_id = $userId;
    $product->category_id = $fields['categoryId']['value'];

    $product->save();

    $linksProductPoint = new LinksProductPoint();

    $linksProductPoint->deleteByProductIds([$productId]);
    $linksProductPoint->add([$productId], [$pointId]);

    ModelsBook::where('product_id', $productId)->delete();
    ModelsMagazine::where('product_id', $productId)->delete();

    switch ($typeId) {
      case 1:
        $book = new ModelsBook();

        $book->author = $fields['author']['value'];
        $book->year_of_publication = $fields['yearOfPublication']['value'];
        $book->year_of_printing = $fields['yearOfPrinting']['value'];
        $book->printing_house = $fields['printingHouse']['value'];
        $book->publishing_house = $fields['publishingHouse']['value'];
        $book->product_id = $product->id;

        $book->save();
        break;
      case 2:
        $dateYearOfPrinting = strtotime($fields['dateOfPrinting']['value']);
        $formattedYearOfPrinting = date('Y-m-d', $dateYearOfPrinting);

        $magazine = new ModelsMagazine();

        $magazine->date_of_printing = $formattedYearOfPrinting;
        $magazine->printing_house = $fields['printingHouse']['value'];
        $magazine->publishing_house = $fields['publishingHouse']['value'];
        $magazine->regularity_id = $fields['regularityId']['value'];
        $magazine->audience_id = $fields['audienceId']['value'];
        $magazine->product_id = $product->id;

        $magazine->save();
        break;
      default:
    }
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
