<?php

namespace App\Services;

use App\Services\Product as ServicesProduct;
use App\Actions\Links\ProductFloor as LinksProductFloor;
use App\Actions\Links\ProductTask as LinksProductTask;
use App\Actions\Other\GetFloorIdsByProductIds;
use App\Actions\Other\GetProductIdsByTaskId;
use App\Actions\ResponsePrepare\Task as ResponsePrepareTask;
use App\Models\Task as ModelsTask;
use Exception;

class Task
{
  public function index(string $type)
  {
    $tasks = null;
    switch ($type) {
      case 'acceptance':
        $tasks = ModelsTask::select('id', 'article', 'date_start', 'date_end', 'user_id')->where('type_id', 1)->get();
        break;
      case 'shipment':
        $tasks = ModelsTask::select('id', 'article', 'date_start', 'date_end', 'user_id')->where('type_id', 2)->get();
        break;
      default:
        throw new Exception('Unknown tasks type');
    }

    return (new ResponsePrepareTask())($tasks);
  }

  public function show(int $taskId)
  {
    $getFloorIdsByProductIds = new GetFloorIdsByProductIds();
    $getProductIdsByTaskId = new GetProductIdsByTaskId();

    $task = ModelsTask::select('id', 'article', 'date_start', 'date_end', 'user_id')
      ->where('id', $taskId)->first();

    $productIds = $getProductIdsByTaskId($taskId);

    $floorIds = $getFloorIdsByProductIds($productIds);

    return (new ResponsePrepareTask())->oneTask($task, $productIds, $floorIds);
  }

  public function create(
    array $fields,
    array $productIds,
    array $floorIds
  ) {
    $task = new ModelsTask();
    $task->article = $fields['article']['value'];
    $task->date_start = $fields['dateStart']['value'];
    $task->date_end = $fields['dateEnd']['value'];
    $task->is_active = false;
    $task->is_available = true;
    $task->user_id = $fields['userId']['value'];
    $task->type_id = $fields['typeId']['value'];

    $task->save();

    $taskId = ModelsTask::select('id')->where('article', $fields['article']['value'])->first()['id'];

    for ($i = 0; $i < count($productIds); $i++) {
      (new LinksProductTask())->add($taskId, $productIds[$i]);
    }

    (new LinksProductFloor())->add($productIds, $floorIds);
  }

  public function update(
    array $fields,
    array $productIds,
    array $floorIds
  ) {
    $task = ModelsTask::where('id', $fields['id']['value'])->first();
    $task->article = $fields['article']['value'];
    $task->date_start = $fields['dateStart']['value'];
    $task->date_end = $fields['dateEnd']['value'];
    $task->is_active = false;
    $task->is_available = true;
    $task->user_id = $fields['userId']['value'];
    $task->type_id = $fields['typeId']['value'];

    $task->save();

    $linksProductTask = new LinksProductTask();
    $linksProductTask->deleteByTaskId($fields['id']['value']);
    $taskId = ModelsTask::select('id')->where('article', $fields['article']['value'])->first()['id'];
    for ($i = 0; $i < count($productIds); $i++) {
      $linksProductTask->add($taskId, $productIds[$i]);
    }

    $linksProductFloor = new LinksProductFloor();
    $linksProductFloor->deleteByProductIds($productIds);

    $linksProductFloor->add($productIds, $floorIds);
  }

  public function destroy(
    string $taskId,
    bool $isDeleteProducts
  ) {
    $task = ModelsTask::select('id')->where('id', $taskId)->first();

    if (!$task) {
      throw new Exception("A task with this id ($taskId) does not exist", 500);
    }

    $productIds = (new LinksProductTask())->deleteByTaskId($taskId);

    (new LinksProductFloor())->deleteByProductIds($productIds);

    if ($isDeleteProducts) {
      (new ServicesProduct())->destroy($productIds);
    }
    $task->delete();
  }
}
