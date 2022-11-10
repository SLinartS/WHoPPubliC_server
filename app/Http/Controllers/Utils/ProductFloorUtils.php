<?php

namespace App\Http\Controllers\Utils;

use App\Http\Controllers\Controller;
use App\Models\ProductFloor;
use Illuminate\Http\Request;
use Throwable;

class ProductFloorUtils extends Controller
{
    public function index()
    {
        try {
            $productsFloors = ProductFloor::select('product_id', 'floor_id')->get();

            return $productsFloors;
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function addProductFloorLink(string $productId, string $floorId)
    {
        try {
            $productFloor = new ProductFloor;

            $productFloor->product_id = $productId;
            $productFloor->floor_id = $floorId;

            $productFloor->save();

            return false;
        } catch (Throwable $th) {
            return $th;
        }
    }
}
