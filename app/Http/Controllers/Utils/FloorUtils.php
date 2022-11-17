<?php

namespace App\Http\Controllers\Utils;

use App\Http\Controllers\Controller;
use App\Models\Floor;
use App\Models\ProductFloor;

class FloorUtils extends Controller
{

    public function countFreeFloorSpace(int $floorId)
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
