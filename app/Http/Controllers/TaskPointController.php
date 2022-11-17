<?php

namespace App\Http\Controllers;

use App\Models\TaskPoint;
use Throwable;

class TaskPointController extends Controller
{
    public function addLink(string $taskId, string $pointId)
    {
        try {
            $taskPoint = new TaskPoint;

            $taskPoint->task_id = $taskId;
            $taskPoint->point_id = $pointId;

            $taskPoint->save();

            return false;
        } catch (Throwable $th) {
            return $th;
        }
    }

    public function deleteLinksByTaskId(string $taksId)
    {
        try {
            $productsTasks = TaskPoint::where('task_id', $taksId)->delete();
        } catch (Throwable $th) {
            throw $th;
        }
    }
}
