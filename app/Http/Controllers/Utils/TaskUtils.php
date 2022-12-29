<?php

namespace App\Http\Controllers\Utils;

use App\Http\Controllers\Controller;
use App\Models\ProductTask;
use App\Models\TaskFloor;
use Throwable;

class TaskUtils extends Controller
{

  public function deletAllProductLinks(int $taskId)
  {
    try {
      ProductTask::where('task_id', $taskId)->delete();
    } catch (Throwable $th) {
      throw $th;
    }
  }

  public function deletAllFloorLinks(int $taskId)
  {
    try {
      TaskFloor::where('task_id', $taskId)->delete();
    } catch (Throwable $th) {
      throw $th;
    }
  }
}
