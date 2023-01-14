<?php

namespace App\Actions\Other;

use App\Models\Floor;
use App\Models\ProductFloor;

class CountFreeFloorSpace
{
  public function __invoke(int $floorId)
  {
    $floor = Floor::select('id', 'capacity')->where('id', $floorId)->first();
    $productsOccupiedSpaceOfFloor = ProductFloor::select('product_id', 'occupied_space')->where('floor_id', $floorId)->get();

    $freeFloorSpace = $floor->capacity;
    foreach ($productsOccupiedSpaceOfFloor as $productOccupiedSpaceOfFloor) {
      $freeFloorSpace -= $productOccupiedSpaceOfFloor->occupied_space;
    }

    return $freeFloorSpace;
  }
}
