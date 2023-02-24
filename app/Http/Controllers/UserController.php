<?php

namespace App\Http\Controllers;

use App\Services\User as ServicesUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class UserController extends Controller
{
  public function index(Request $request, ServicesUser $servicesUser)
  {
    try {
      $search = $request->query('search');
      $response = $servicesUser->index($search);

      return response()->json($response, 200);
    } catch (Throwable $th) {
      return response($th, 500);
    }
  }

  public function show(int $id, ServicesUser $servicesUser)
  {
    try {
      $response = $servicesUser->show($id);

      return response()->json($response, 200);
    } catch (Throwable $th) {
      return response($th, 500);
    }
  }

  public function store(
    Request $request,
    ServicesUser $servicesUser
  ): JsonResponse | Response {
    try {
      $fields = $request->fields;
      $workSchedules = $request->workSchedules;
      $servicesUser->store(
        $fields,
        $workSchedules,
      );

      return response()->json([
        'message' => 'The user has been added'
      ], 200);
    } catch (Throwable $th) {
      return response($th, 500);
    }
  }

  public function update(
    int $id,
    Request $request,
    ServicesUser $servicesUser
  ): JsonResponse | Response {
    try {
      $fields = $request->fields;
      $workSchedules = $request->workSchedules;
      $servicesUser->update(
        $id,
        $fields,
        $workSchedules,
      );

      return response()->json([
        'message' => 'The user has been updated'
      ], 200);
    } catch (Throwable $th) {
      return response($th, 500);
    }
  }

  public function destroy(
    int $id,
    ServicesUser $servicesUser
  ): JsonResponse | Response {
    try {
      $servicesUser->destroy($id);

      return response()->json([
        'message' => 'The user has been deleted'
      ], 200);
    } catch (Throwable $th) {
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }
}
