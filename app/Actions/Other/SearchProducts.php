<?php

namespace App\Actions\Other;

use App\Models\Product as ModelsProduct;
use App\Models\ProductFloor as ModelsProductFloor;
use Illuminate\Contracts\Database\Eloquent\Builder;

class SearchProducts
{
  public function __invoke(array $floorIds, string $search): array
  {
    $productIds = ModelsProductFloor::select('product_id')
      ->whereIn('floor_id', $floorIds)
      ->get()
      ->pluck('product_id')
      ->toArray();

    $searchField = '%' . $search . '%';
    $foundProductIds = ModelsProduct::select('id')
      ->whereIn('id', $productIds)
      ->where(function (Builder $query) use ($searchField) {
        /** @var Illuminate\Contracts\Database\Eloquent\Builder $query **/
        $query->where('article', 'like', $searchField)
              ->orWhere('title', 'like', $searchField)
              ->orWhere('author', 'like', $searchField)
              ->orWhere('year_of_publication', 'like', $searchField)
              ->orWhere('number', 'like', $searchField)
              ->orWhere('year_of_printing', 'like', $searchField)
              ->orWhere('printing_house', 'like', $searchField)
              ->orWhere('publishing_house', 'like', $searchField);
      })

      ->get()
      ->pluck('id')
      ->toArray();

    return $foundProductIds;
  }
}
