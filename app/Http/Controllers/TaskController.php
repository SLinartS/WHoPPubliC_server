<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Task;
use App\Models\Zone;

class TaskController extends Controller
{
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
