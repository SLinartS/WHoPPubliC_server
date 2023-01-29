<?php

namespace App\Http\Controllers;

use App\Services\Task as ServicesTask;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class TaskController extends Controller
{
  public function index(
    string $type,
    ServicesTask $servicesTask
  ): JsonResponse | Response {
    try {
      $response = $servicesTask->index($type);

      return response()->json($response, 200);
    } catch (Throwable $th) {
      throw $th;
    }
  }

  public function show(
    int $taskId,
    ServicesTask $servicesTask
  ): JsonResponse | Response {
    try {
      $response = $servicesTask->show($taskId);

      return response()->json($response, 200);
    } catch (Throwable $th) {
      throw $th;
    }
  }

  public function create(
    Request $request,
    ServicesTask $servicesTask
  ): JsonResponse | Response {
    try {
      $fields = $request->fields;
      $productIds = $request->productIds;
      $floorIds = $request->floorIds;
      $pointIds = $request->pointIds;
      $userId = $request->typeId;
      $taskTypeId = $request->typeId;

      $servicesTask->create(
        $fields,
        $productIds,
        $floorIds,
        $pointIds,
        $userId,
        $taskTypeId
      );

      return response()->json([
        'message' => 'The task has been added'
      ], 200);
    } catch (Throwable $th) {
      return response($th, 500);
    }
  }

  public function update(
    Request $request,
    ServicesTask $servicesTask
  ): JsonResponse | Response {
    try {
      $fields = $request->fields;
      $productIds = $request->productIds;
      $floorIds = $request->floorIds;
      $pointIds = $request->pointIds;
      $userId = $request->typeId;
      $taskTypeId = $request->typeId;

      $servicesTask->update(
        $fields,
        $productIds,
        $floorIds,
        $pointIds,
        $userId,
        $taskTypeId
      );

      return response()->json([
        'message' => 'The task has been changed'
      ], 200);
    } catch (Throwable $th) {
      return response($th, 500);
    }
  }

  public function destroy(
    string $taskId,
    Request $request,
    ServicesTask $servicesTask
  ): JsonResponse | Response {
    try {
      $isDeleteProducts = (bool) $request->query('deleteProducts');
      $servicesTask->destroy(
        $taskId,
        $isDeleteProducts,
      );

      return response()->json([
        'message' => 'The task has been deleted'
      ], 200);
    } catch (Throwable $th) {
      return response($th, 500);
    }
  }
}
