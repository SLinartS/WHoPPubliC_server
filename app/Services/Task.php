<?php

namespace App\Services;

use App\Services\Product as ServicesProduct;
use App\Actions\Links\ProductFloor as LinksProductFloor;
use App\Actions\Links\ProductTask as LinksProductTask;
use App\Actions\Links\ProductPoint as LinksProductPoint;
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
      case 'intra':
        $tasks = ModelsTask::select('id', 'article', 'date_start', 'date_end', 'user_id')->where('type_id', 3)->get();
        break;
      default:
        throw new Exception('Unknown tasks type');
    }

    return (new ResponsePrepareTask())($tasks);
  }

  public function show(int $taskId)
  {
    $task = ModelsTask::select('id', 'article', 'date_start', 'date_end', 'user_id')
      ->where('id', $taskId)->first();

    $productIds = (new LinksProductTask())->getProductIdsByTaskIds([$taskId]);

    $floorIds = (new LinksProductFloor())->getFloorIdsByProductIds($productIds);

    $pointIds = (new LinksProductPoint())->getPointIdsByProductIds($productIds);

    return (new ResponsePrepareTask())->oneTask($task, $productIds, $floorIds, $pointIds);
  }

  public function create(
    array $fields,
    array $productIds,
    array $floorIds,
    array $pointIds,
    int $userId,
    int $taskTypeId
  ) {
    $task = new ModelsTask();
    $task->article = $fields['article']['value'];
    $task->date_start = $fields['dateStart']['value'];
    $task->date_end = $fields['dateEnd']['value'];
    $task->is_active = false;
    $task->is_available = true;
    $task->user_id = $userId;
    $task->type_id = $taskTypeId;

    $task->save();

    $taskId = ModelsTask::select('id')->where('article', $fields['article']['value'])->first()['id'];

    (new LinksProductTask())->add($productIds, $taskId);

    switch($taskTypeId) {
      case 1:
      case 3:
        (new LinksProductFloor())->add($productIds, $floorIds);
        break;
      case 2:
        (new LinksProductPoint())->add($productIds, $pointIds);
        break;
      default:
    }
  }

  public function update(
    array $fields,
    array $productIds,
    array $floorIds,
    array $pointIds,
    int $userId,
    int $taskTypeId
  ) {
    $task = ModelsTask::where('id', $fields['id']['value'])->first();
    $task->article = $fields['article']['value'];
    $task->date_start = $fields['dateStart']['value'];
    $task->date_end = $fields['dateEnd']['value'];
    $task->is_active = false;
    $task->is_available = true;
    $task->user_id = $userId;
    $task->type_id = $taskTypeId;

    $task->save();

    $linksProductTask = new LinksProductTask();
    $linksProductTask->deleteByTaskId($fields['id']['value']);
    $taskId = ModelsTask::select('id')->where('article', $fields['article']['value'])->first()['id'];
    $linksProductTask->add($productIds, $taskId);


    $linksProductFloor = new LinksProductFloor();
    $linksProductPoint = new LinksProductPoint();
    switch($taskTypeId) {
      case 1:
        $linksProductFloor->deleteByProductIds($productIds);
        $linksProductFloor->add($productIds, $floorIds);
        break;
      case 3:
        $linksProductFloor->deleteByProductIds($productIds, false);
        $linksProductFloor->add($productIds, $floorIds);
        break;
      case 2:
        $linksProductPoint->deleteByProductIds($productIds);
        $linksProductPoint->add($productIds, $pointIds);
        break;
      default:
    }
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
