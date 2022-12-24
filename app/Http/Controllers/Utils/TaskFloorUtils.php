<?php

namespace App\Http\Controllers\Utils;

use App\Http\Controllers\Controller;
use App\Models\TaskFloor;
use Throwable;

class TaskFloorUtils extends Controller
{

  public function getFloorIdsByTaskId(int $taskId): array
  {
    try {
      $floorIds = TaskFloor::select('floor_id')
        ->where('task_id', $taskId)->get()->pluck('floor_id')->toArray();

      return $floorIds;
    } catch (Throwable $th) {
      throw $th;
    }
  }
}
