<?php

namespace App\Http\Controllers;

use App\Models\ProductTask;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class ProductTaskController extends Controller
{
    public function addProductTaskLink(string $taskArticle, string $productId)
    {
        try {
            $taskController = new TaskController;

            $taskId = $taskController->getTaskIdByArticle($taskArticle);
            if ($taskId['error']) {
                return response($taskId['data'], 404);
            }

            $productTask = new ProductTask;

            $productTask->task_id = $taskId['data'];
            $productTask->product_id = $productId;

            $productTask->save();

            return false;
        } catch (Throwable $th) {
            return $th->getMessage();
        }
    }
}
