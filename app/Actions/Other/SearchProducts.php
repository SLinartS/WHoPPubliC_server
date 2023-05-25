<?php

namespace App\Actions\Other;

use App\Models\Book as ModelsBook;
use App\Models\Magazine as ModelsMagazine;
use App\Models\Product as ModelsProduct;
use App\Models\ProductFloor as ModelsProductFloor;
use Illuminate\Contracts\Database\Eloquent\Builder;

class SearchProducts
{
  public function __invoke(array $floorIds, string $search)
  {
    $productFloorIds = ModelsProductFloor::select('product_id')
      ->whereIn('floor_id', $floorIds)
      ->get()
      ->pluck('product_id')
      ->toArray();

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
      )
      ->whereIn('products.id', $productFloorIds);


    $productsWithoutSearch = $products->get();

    if ($searchField) {
      $products = $products
        ->where(function (Builder $query) use ($searchField) {
          /** @var Illuminate\Contracts\Database\Eloquent\Builder $query **/
          $query->where('products.article', 'like', $searchField)
            ->orWhere('products.title', 'like', $searchField)
            ->orWhere('products.number', 'like', $searchField)
            ->orWhere('products.note', 'like', $searchField)
            ->orWhere('categories.alias', 'like', $searchField)
            ->orWhere('product_types.alias', 'like', $searchField);
        })
        ->get();
    } else {
      $products = $products->get();
    }

    $productsWithAddInfo = [];
    foreach ($productsWithoutSearch as $product) {
      switch ($product->type_id) {
        case 1:
          $additionalInformation = ModelsBook::select(
            'product_id',
            'author',
            'year_of_publication',
            'year_of_printing',
            'printing_house',
            'publishing_house'
          )->where('product_id', $product->id);

          $additionalInformationWithoutSearch = $additionalInformation->first();

          if ($searchField) {
            $additionalInformation->where('author', 'like', $searchField)
              ->orWhere('year_of_publication', 'like', $searchField)
              ->orWhere('year_of_printing', 'like', $searchField)
              ->orWhere('printing_house', 'like', $searchField)
              ->orWhere('publishing_house', 'like', $searchField);
          }

          $additionalInformation = $additionalInformation->first();

          if ($additionalInformation) {
            array_push($productsWithAddInfo, array_merge($product->toArray(), $additionalInformation->toArray()));
          } elseif ($products->contains('id', $additionalInformationWithoutSearch->product_id)) {
            array_push($productsWithAddInfo, array_merge($product->toArray(), $additionalInformationWithoutSearch->toArray()));
          }
          break;
        case 2:
          $additionalInformation = ModelsMagazine::join('regularities', 'regularities.id', 'magazines.regularity_id')
            ->join('audiences', 'audiences.id', 'magazines.audience_id')
            ->select(
              'magazines.product_id',
              'magazines.printing_house',
              'magazines.publishing_house',
              'magazines.date_of_printing',
              'magazines.regularity_id',
              'magazines.audience_id',
              'regularities.alias as regularity_alias',
              'audiences.alias as audience_alias',
            )->where('magazines.product_id', $product->id);;

          $additionalInformationWithoutSearch = $additionalInformation->first();

          if ($searchField) {
            $additionalInformation->where('magazines.printing_house', 'like', $searchField)
              ->orWhere('magazines.publishing_house', 'like', $searchField)
              ->orWhere('magazines.date_of_printing', 'like', $searchField)
              ->orWhere('regularities.alias', 'like', $searchField)
              ->orWhere('audiences.alias', 'like', $searchField);
          }

          $additionalInformation = $additionalInformation->first();

          if ($additionalInformation) {
            array_push($productsWithAddInfo, array_merge($product->toArray(), $additionalInformation->toArray()));
          } elseif ($products->contains('id', $additionalInformationWithoutSearch->product_id)) {
            array_push($productsWithAddInfo, array_merge($product->toArray(), $additionalInformationWithoutSearch->toArray()));
          }
          break;
        default:
      }
    }

    $productIds = [];

    foreach ($productsWithAddInfo as $product) {
      array_push($productIds, $product['id']);
    }

    $foundProductIds = $productIds;

    foreach ($products->toArray() as $product) {
      if (!in_array($product['id'], $productIds)) {
        array_push($foundProductIds, $product['id']);
      }
    }

    return $foundProductIds;
  }
}
