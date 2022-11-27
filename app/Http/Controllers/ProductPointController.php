<?php

namespace App\Http\Controllers;

use App\Models\ProductPoint;
use Throwable;

class ProductPointController extends Controller
{
    public function addLink(int $productId, int $pointId)
    {
        try {
            $productFloor = new ProductPoint;
            $productFloor->product_id = $productId;
            $productFloor->point_id = $pointId;
            $productFloor->save();
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function deleteLinksByProductId(string $taksId)
    {
        try {
            ProductPoint::where('task_id', $taksId)->delete();
        } catch (Throwable $th) {
            throw response()->json(['message' => $th->getMessage()]);
        }
    }
}
