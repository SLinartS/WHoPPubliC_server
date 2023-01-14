<?php

namespace App\Actions\Other;

use App\Models\ProductTask;
use Exception;

class CheckTaskLinkExist
{
  public function __invoke(string $productId)
  {
    $productsTasks = ProductTask::select('task_id')->where('product_id', $productId)->get();
    if ($productsTasks->count() > 0) {
      $tasksString = $productsTasks->implode('task_id', ', ');
      throw new Exception('Нельзя удалить продукт с которым связаны задачи: ' . $tasksString);
    }
  }
}
