<?php

namespace App\Http\Controllers;

use App\Actions\TaskResponsePrepare;
use App\Models\Task;
use Illuminate\Http\Request;
use Exception;
use Throwable;

class TaskController extends Controller
{

    public function index($type, TaskResponsePrepare $taskResponsePrepare)
    {
        $tasks = null;
        switch ($type) {
            case 'acceptance':
                $tasks = Task::select('id', 'article', 'date_start', 'date_end', 'user_id')->where('type_id', 1)->get();
                break;
            case 'shipment':
                $tasks = Task::select('id', 'article', 'date_start', 'date_end', 'user_id')->where('type_id', 2)->get();
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
            $task->article = $fields['article']['value'];
            $task->date_start = $fields['dateStart']['value'];
            $task->date_end = $fields['dateEnd']['value'];;
            $task->user_id = $fields['userId']['value'];
            $task->type_id = $fields['typeId']['value'];

            $task->save();

            try {
                $taskId = Task::select('id')->where('article', $fields['article']['value'])->first()['id'];

                for ($i = 0; $i < count($arrays['products']['value']); $i++) {
                    $error = $productTaskController->addProductTaskLink($taskId, $arrays['products']['value'][$i]);
                    if ($error) {
                        throw new Exception($error);
                    }
                }

                for ($i = 0; $i < count($arrays['points']['value']); $i++) {
                    $error = $taskPointController->addLink($taskId, $arrays['points']['value'][$i]);
                    if ($error) {
                        throw new Exception($error);
                    }
                }
            } catch (Throwable $th) {
                return response($th, 422);
            }

            return response('The task has been added', 200);
        } catch (Throwable $th) {
            return response($th, 422);
        }
    }

    public function deleteTask(
        string $taskId,
        ProductTaskController $productTaskController,
        TaskPointController $taskPointController
    ) {
        try {
            $task = Task::select('id')->where('id', $taskId)->first();
            if ($task) {

                try {
                    $productTaskController->deleteLinksByTaskId($taskId);
                } catch (\Throwable $th) {
                    return response($th, 500);
                }

                try {
                    $taskPointController->deleteLinksByTaskId($taskId);
                } catch (\Throwable $th) {
                    return response($th, 500);
                }

                $task->delete();
                return response('The task has been deleted', 200);
            }
            return response("A task with this id ($taskId) does not exist", 404);
        } catch (Throwable $th) {
            return response($th, 422);
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
