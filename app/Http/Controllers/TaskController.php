<?php

namespace App\Http\Controllers;

use App\Actions\TaskResponsePrepare;
use App\Models\Task;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class TaskController extends Controller
{

    public function index($type, TaskResponsePrepare $taskResponsePrepare)
    {
        $tasks = null;
        switch ($type) {
            case 'acceptance':
                $tasks = Task::select('id', 'article', 'date_start', 'date_end', 'user_id')->where("type_id", 1)->get();
                break;
            case 'shipment':
                $tasks = Task::select('id', 'article', 'date_start', 'date_end', 'user_id')->where("type_id", 2)->get();
                break;
            default:
                return response('Unknown tasks type', 404);
        }

        $response = $taskResponsePrepare($tasks);

        return response()->json($response, 200);
    }

    public function addTask(Request $request)
    {
        try {
            $dateToday = date('Y-m-d');
            $dateTomorrow = new DateTime('tomorrow');
            $dateTomorrow = $dateTomorrow->format('Y-m-d');

            $task = new Task;
            $task->title = $request->title;
            $task->date_start = $dateToday;
            $task->date_end = $dateTomorrow;
            $task->user_id = $request->userId;
            $task->type_id = $request->typeId;

            $task->save();

            return response('The task has been added', 200);
        } catch (Throwable $th) {
            return response($th->getMessage(), 422);
        }
    }

    public function deleteTask($taskArticle)
    {
        try {
            $taskId = $this->getTaskIdByArticle($taskArticle);
            if ($taskId['error']) {
                return response($taskId['data'], 404);
            }

            $task = Task::where('id', $taskId['data'])->first();

            if(count($task) > 0) {
                $task->delete();
                return response('The task has been deleted', 200);
            }
            return response("A task with this title ($taskArticle) does not exist", 404);
            
        } catch (Throwable $th) {
            return response($th->getMessage(), 422);
        }
    }

    public function getTaskIdByArticle(string $taskArticle)
    {
        try {
            $taskId = Task::select('id')->where('article', $taskArticle)->first()->id;

            return [
                'error' => false,
                'data' => $taskId
            ];
        } catch (Throwable $th) {
            return [
                'error' => true,
                'data' => "A task with this article ('$taskArticle') does not exist"
            ];
        }
    }
}
