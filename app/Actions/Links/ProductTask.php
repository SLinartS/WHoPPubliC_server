<?php

namespace App\Actions\Links;

use App\Models\ProductTask as ModelsProductTask;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class ProductTask
{
  public function add(string $taskId, string $productId)
  {
    $productTask = new ModelsProductTask();
    $productTask->task_id = $taskId;
    $productTask->product_id = $productId;

    $productTask->save();
  }

  public function deleteByTaskId(int $taskId): array
  {
    $productIds = ModelsProductTask::select('product_id')->where('task_id', $taskId)->get();
    $productIds = array_map(
      function ($object) {
        return $object['product_id'];
      },
      $productIds->toArray()
    );
    ModelsProductTask::where('task_id', $taskId)->delete();
    return $productIds;
  }

  public function deleteByProductIds(array $productIds)
  {
    $productIds = ModelsProductTask::select('product_id')->whereIn('product_id', $productIds)->get();
    $productIds = array_map(
      function ($object) {
        return $object['product_id'];
      },
      $productIds->toArray()
    );
    ModelsProductTask::whereIn('product_id', $productIds)->delete();
    return $productIds;
  }

  public function getByTaskId(string $taksId)
  {
    $productsTasks = ModelsProductTask::where('task_id', $taksId)->get();
    return
    $productsTasks;
  }

  public function getByProductsIds(array $productIds): Collection
  {
    $productsTasks = ModelsProductTask::whereIn('product_id', $productIds)->get();
    return $productsTasks;
  }

  public function getIdsProductAndIdsTask()
  {
    $productsTasks = ModelsProductTask::select('product_id', 'task_id')->get();
    return $productsTasks;
  }
}
