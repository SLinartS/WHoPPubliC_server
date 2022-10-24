<?php

namespace App\Http\Controllers;

use App\Actions\TaskResponsePrepare;
use App\Models\Section;
use App\Models\Task;
use App\Models\Zone;

class TaskController extends Controller
{

    public function index($type, TaskResponsePrepare $taskResponsePrepare)
    {
        $tasks = null;
        switch ($type) {
            case 'acceptance':
                $tasks = Task::select('id', 'title', 'date_start', 'date_end', 'user_id')->where("task_type_id", 1)->get();
                break;
            case 'shipment':
                $tasks = Task::select('id', 'title', 'date_start', 'date_end', 'user_id')->where("task_type_id", 2)->get();
                break;
            default:
                return response('Unknown tasks type', 404);
        }

        $response = $taskResponsePrepare($tasks);

        return response()->json($response, 200);
    }

    public function test()
    {
        $task = Task::find(6);
        $products = $task->products;

        $zones = Zone::select()->find(1);
        $sections = $zones->sections;

        $section = Section::select()->find(1);
        $zone = $section->zone;

        return [
            'products' => $products,
            'sections' => $sections,
            'zone' => $zone
        ];
    }
}
