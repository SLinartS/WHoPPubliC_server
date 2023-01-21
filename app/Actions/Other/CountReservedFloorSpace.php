<?php

namespace App\Actions\Other;

use App\Models\ProductFloor as ModelsProductFloor;
use App\Models\ProductPoint as ModelsProductPoint;

class CountReservedFloorSpace
{
  public function __invoke(int $floorId)
  {
    $productsReservedSpaceOfFloor = ModelsProductFloor::select('product_id', 'occupied_space')
      ->where('floor_id', $floorId)
      ->where('is_actual', false)
      ->get();

    $reservedFloorSpace = 0;
    foreach ($productsReservedSpaceOfFloor as $productReservedSpaceOfFloor) {
      $reservedFloorSpace += $productReservedSpaceOfFloor->occupied_space;
    }

    return $reservedFloorSpace;
  }
}
