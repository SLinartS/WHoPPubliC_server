<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\FloorUtils;
use App\Models\Product;
use App\Models\ProductFloor;
use Throwable;

class ProductFloorController extends Controller
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

    public function addProductFloorLinks(array $productIds, array $floorIds)
    {
        try {
            $floorUtils = new FloorUtils;
            for ($productIndex = 0; $productIndex < count($productIds); $productIndex++) {
                $productId = $productIds[$productIndex];
                $initialNumberOfProduct = $numberOfProduct = Product::select('number')->where('id', $productId)->first()->number;
                $addedNumberOfProduct = 0;

                $indexOfFloor = 0;
                while ($indexOfFloor < count($floorIds)) {

                    $floorId = $floorIds[$indexOfFloor];
                    $freeSpaceOfFloor = $floorUtils->countFreeFloorSpace($floorId);

                    if ($freeSpaceOfFloor === 0) {
                        $indexOfFloor++;
                        continue;
                    }

                    if ($initialNumberOfProduct <= $freeSpaceOfFloor) {
                        $this->addProductFloorLink($productId, $floorId, $initialNumberOfProduct - $addedNumberOfProduct);
                        break;
                    } elseif ($numberOfProduct <= $freeSpaceOfFloor) {
                        $this->addProductFloorLink($productId, $floorId, $numberOfProduct);
                        $addedNumberOfProduct += $numberOfProduct;
                        if ($addedNumberOfProduct === $initialNumberOfProduct) {
                            break;
                        }
                        $numberOfProduct = $initialNumberOfProduct - $addedNumberOfProduct;
                        $indexOfFloor++;
                    } else {
                        $numberOfProduct = $freeSpaceOfFloor;
                    }
                }
            }
            return false;
        } catch (Throwable $th) {
            throw $th;
        }
    }

    private function addProductFloorLink(int $productId, int $floorId, int $occupiedSpace)
    {
        $productFloor = new ProductFloor;
        $productFloor->product_id = $productId;
        $productFloor->floor_id = $floorId;
        $productFloor->occupied_space = $occupiedSpace;
        $productFloor->save();
    }
}
