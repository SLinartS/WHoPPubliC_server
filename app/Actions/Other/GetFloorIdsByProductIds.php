<?php

namespace App\Actions\Other;

use App\Models\ProductFloor;

class GetFloorIdsByProductIds
{
  public function __invoke(array $productIds)
  {
    $floorIds = ProductFloor::select('floor_id')
      ->whereIn('product_id', $productIds)
      ->get();

    $floorIds = array_map(
      function ($object) {
        return $object['floor_id'];
      },
      $floorIds->toArray()
    );

    return $floorIds;
  }
}
