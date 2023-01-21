<?php

namespace App\Actions\Links;

use App\Models\ProductTask as ModelsProductTask;
use Illuminate\Database\Eloquent\Collection;

class ProductTask
{
  public function add(array $productIds, string $taskId)
  {
    foreach ($productIds as $productId) {
      $productTask = new ModelsProductTask();
      $productTask->task_id = $taskId;
      $productTask->product_id = $productId;
      $productTask->save();
    }
  }

  public function deleteByTaskId(int $taskId): array
  {
    $productIds = ModelsProductTask::select('product_id')
    ->where('task_id', $taskId)
    ->get()
    ->pluck('product_id')
    ->toArray();

    ModelsProductTask::where('task_id', $taskId)->delete();
    return $productIds;
  }

  public function deleteByProductIds(array $productIds)
  {
    $productIds = ModelsProductTask::select('product_id')
    ->whereIn('product_id', $productIds)
    ->get()
    ->pluck('product_id')
    ->toArray();

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

  public function getProductIdsByTaskIds(array $taskIds): array
  {
    $productIds = ModelsProductTask::select('product_id')
      ->whereIn('task_id', $taskIds)
      ->get()->pluck('product_id')->toArray();

    return $productIds;
  }

  public function getTaskIdByProductId(int $productId)
  {
    $idsProductWithLinkToTask = $this->getIdsProductAndIdsTask();

    $isLinkedToTask = false;
    $taskId = 0;
    if ($idsProductWithLinkToTask->contains('product_id', $productId)) {
      $isLinkedToTask = true;
      $taskId = $idsProductWithLinkToTask->firstWhere('product_id', $productId)['task_id'];
    }

    return ['isLinkedToTask' => $isLinkedToTask, 'taskId' => $taskId];
  }
}
