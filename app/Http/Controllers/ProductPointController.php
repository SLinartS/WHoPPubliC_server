<?php

namespace App\Http\Controllers;

use App\Models\ProductPoint;
use Throwable;

class ProductPointController extends Controller
{
    public function addLinks(
        array $productIds,
        array $pointIds
    ) {
        try {
            for ($pointIndex = 0; $pointIndex < 1; $pointIndex++) {
                for ($productIndex = 0; $productIndex < count($productIds); $productIndex++) {
                    $this->addLink($productIds[$productIndex], $pointIds[$pointIndex]);
                }
            }

            return false;
        } catch (Throwable $th) {
            throw $th;
        }
    }

    private function addLink(int $productId, int $pointId)
    {
        $productFloor = new ProductPoint;
        $productFloor->product_id = $productId;
        $productFloor->point_id = $pointId;
        $productFloor->save();
    }

    public function deleteLinksByProductId(string $taksId)
    {
        try {
            ProductPoint::where('task_id', $taksId)->delete();
        } catch (Throwable $th) {
            throw $th;
        }
    }
}
