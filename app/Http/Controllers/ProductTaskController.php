<?php

namespace App\Http\Controllers;

use App\Models\ProductTask;
use Throwable;

class ProductTaskController extends Controller
{
    public function getLinksByTaskId(string $taksId)
    {
        try {
            $productsTasks = ProductTask::where('task_id', $taksId)->get();
            return $productsTasks;
        } catch (Throwable $th) {
            throw $th;
        }
    }
    
    public function deleteLinksByTaskId(string $taksId)
    {
        try {
            ProductTask::where('task_id', $taksId)->delete();
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function addLink(string $taskId, string $productId)
    {
        try {
            $productTask = new ProductTask;

            $productTask->task_id = $taskId;
            $productTask->product_id = $productId;

            $productTask->save();

            return false;
        } catch (Throwable $th) {
            return $th;
        }
    }
}
