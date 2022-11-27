<?php

namespace App\Http\Controllers\Utils;

use App\Http\Controllers\Controller;
use App\Models\LocationHistory;
use App\Models\Product;
use App\Models\ProductFloor;
use App\Models\ProductPoint;
use App\Models\ProductTask;
use Exception;
use Throwable;

class ProductUtils extends Controller
{

    public function getProductsNumbersByIds(array $productIds)
    {
        try {
            $products = Product::select('id', 'number')
                ->whereIn('id', $productIds)
                ->get();

            return $products;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteProductsByProductIds(array $productIds)
    {
        try {
            ProductFloor::whereIn('product_id', $productIds)->delete();
            LocationHistory::whereIn('product_id', $productIds)->delete();
            ProductPoint::whereIn('product_id', $productIds)->delete();
            Product::whereIn('id', $productIds)->delete();
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function checkTaskLinkExist(string $productId)
    {
        try {
            $productsTasks = ProductTask::select('task_id')->where('product_id', $productId)->get();
            if ($productsTasks->count() > 0) {
                $tasksString = $productsTasks->implode('task_id', ', ');
                throw new Exception('Нельзя удалить продукт с которым связаны задачи: ' . $tasksString);
            }
        } catch (Throwable $th) {
            throw $th;
        }
    }
}
