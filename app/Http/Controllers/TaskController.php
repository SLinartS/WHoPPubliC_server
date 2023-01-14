<?php

namespace App\Http\Controllers;

use App\Services\Task as ServicesTask;
use Illuminate\Http\Request;
use Throwable;

class TaskController extends Controller
{
  public function index(
    string $type,
    ServicesTask $servicesTask
  ) {
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
  ) {
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
  ) {
    try {
      $fields = $request->fields;
      $productIds = $request->productIds;
      $floorIds = $request->warehousePointIds;

      $servicesTask->create(
        $fields,
        $productIds,
        $floorIds,
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
  ) {
    try {
      $fields = $request->fields;
      $productIds = $request->productIds;
      $floorIds = $request->warehousePointIds;

      $servicesTask->update(
        $fields,
        $productIds,
        $floorIds,
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
  ) {
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
