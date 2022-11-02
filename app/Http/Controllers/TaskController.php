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

    public function addTask(Request $request, ProductTaskController $productTaskController, TaskPointController $taskPointController)
    {
        $fields = $request->fields;
        $arrays = $request->arrays;
        try {
            $task = new Task;
            $task->article = $fields["article"];
            $task->date_start = $fields["dateStart"];
            $task->date_end = $fields["dateEnd"];;
            $task->user_id = $fields["userId"];
            $task->type_id = $fields["typeId"];

            $task->save();

            try {
                $taskId = Task::select('id')->where('article', $fields["article"])->first()['id'];

                for ($i = 0; $i < count($arrays["products"]); $i++) {
                    $error = $productTaskController->addProductTaskLink($taskId, $arrays["products"][$i]);
                    if ($error) {
                        throw new Exception($error);
                    }
                }

                for ($i = 0; $i < count($arrays["points"]); $i++) {
                    $error = $taskPointController->addTaskPointLink($taskId, $arrays["points"][$i]);
                    if ($error) {
                        throw new Exception($error);
                    }
                }
            } catch (Throwable $th) {
                return response($th->getMessage(), 422);
            }

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

            if (count($task) > 0) {
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
