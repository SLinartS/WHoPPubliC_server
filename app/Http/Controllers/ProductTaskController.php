<?php

namespace App\Http\Controllers;

use App\Models\ProductTask;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class ProductTaskController extends Controller
{
    public function addProductTaskLink(string $taskId, string $productId)
    {
        try {
            $productTask = new ProductTask;

            $productTask->task_id = $taskId;
            $productTask->product_id = $productId;

            $productTask->save();

            return false;
        } catch (Throwable $th) {
            return $th->getMessage();
        }
    }
}
