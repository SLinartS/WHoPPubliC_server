<?php

namespace App\Http\Controllers;

use App\Models\TaskFloor;
use Throwable;

class TaskFloorController extends Controller
{
    public function addLinks(
        string $taskId,
        array $floorIds
    ) {
        try {

            for ($floorIndex = 0; $floorIndex < count($floorIds); $floorIndex++) {
                $this->addLink($taskId, $floorIds[$floorIndex]);
            }


            return false;
        } catch (Throwable $th) {
            throw $th;
        }
    }

    private function addLink(int $taskId, int $floorId)
    {
        $productFloor = new TaskFloor;
        $productFloor->task_id = $taskId;
        $productFloor->floor_id = $floorId;
        $productFloor->save();
    }
}
