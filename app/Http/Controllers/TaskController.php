<?php

namespace App\Http\Controllers;

use App\Actions\TaskResponsePrepare;
use App\Http\Controllers\Utils\ProductUtils;
use App\Http\Controllers\Utils\TaskFloorUtils;
use App\Models\Task;
use App\Models\TaskFloor;
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

    public function getOneTask($taskId, TaskResponsePrepare $taskResponsePrepare)
    {
        $task = Task::select('id', 'article', 'date_start', 'date_end', 'user_id')->where('id', $taskId)->first();

        $productUtils = new ProductUtils;
        $productIds = $productUtils->getProductIdsByTaskId($taskId);

        $taskFloorUtils = new TaskFloorUtils;
        $warehousePointIds = $taskFloorUtils->getFloorIdsByTaskId($taskId);

        $response = $taskResponsePrepare->oneTask($task, $productIds, $warehousePointIds);

        return response()->json($response, 200);
    }

    public function addTask(
        Request $request,
        TaskFloorController $taskFloorController,
        ProductTaskController $productTaskController
    ) {
        $fields = $request->fields;
        $productIds = $request->productIds;
        $warehousePointIds = $request->warehousePointIds;

        try {
            $task = new Task;
            $task->article = $fields['article']['value'];
            $task->date_start = $fields['dateStart']['value'];
            $task->date_end = $fields['dateEnd']['value'];
            $task->is_active = false;
            $task->is_available = true;
            $task->user_id = $fields['userId']['value'];
            $task->type_id = $fields['typeId']['value'];

            $task->save();

            try {
                $taskId = Task::select('id')->where('article', $fields['article']['value'])->first()['id'];

                try {
                    for ($i = 0; $i < count($productIds); $i++) {
                        $error = $productTaskController->addLink($taskId, $productIds[$i]);
                        if ($error) {
                            throw new Exception($error);
                        }
                    }
                } catch (\Throwable $th) {
                    throw $th;
                }

                try {
                    $taskFloorController->addLinks($taskId, $warehousePointIds);
                } catch (Throwable $th) {
                    throw $th;
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
        Request $request,
        ProductTaskController $productTaskController,
        ProductUtils $productUtils
    ) {
        try {
            $task = Task::select('id')->where('id', $taskId)->first();

            if ($task) {
                try {
                    $productIds = $productTaskController->deleteLinksByTaskId($taskId);
                } catch (Throwable $th) {
                    throw $th;
                }

                try {
                    TaskFloor::where('task_id', $taskId)->delete();
                } catch (Throwable $th) {
                    throw $th;
                }

                if ($request->query('deleteProducts')) {
                    try {
                        $productUtils->deleteProductsByProductIds($productIds);
                    } catch (Throwable $th) {
                        throw $th;
                    }
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
