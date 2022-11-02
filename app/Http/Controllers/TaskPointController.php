<?php

namespace App\Http\Controllers;

use App\Models\TaskPoint;
use Illuminate\Http\Request;
use Throwable;

class TaskPointController extends Controller
{
    public function addTaskPointLink(string $taskId, string $pointId)
    {
        try {
            $taskPoint = new TaskPoint;

            $taskPoint->task_id = $taskId;
            $taskPoint->point_id = $pointId;

            $taskPoint->save();

            return false;
        } catch (Throwable $th) {
            return $th->getMessage();
        }
    }
}
