<?php

namespace App\Http\Controllers;

use App\Services\Map as ServicesMap;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class MapController extends Controller
{
  public function index(
    Request $request,
    ServicesMap $servicesMap,
  ): JsonResponse | Response {
    try {
      $search = $request->query('search');
      $response = $servicesMap->index($search);

      return response()->json($response, 200);
    } catch (Throwable $th) {
      return response($th, 500);
    }
  }

  public function update(
    ServicesMap $servicesMap,
    Request $request,
  ): JsonResponse | Response {
    try {
      $zone = $request->zone;

      $servicesMap->update($zone);

      return response()->json([
        'message' => 'The map has been changed'
      ], 200);
    } catch (Throwable $th) {
      return response($th, 500);
    }
  }

  public function destroy(
    int $zoneId,
    ServicesMap $servicesMap,
  ): JsonResponse | Response {
    try {
      $servicesMap->destroy($zoneId);

      return response()->json([
        'message' => 'The zone has been deleted'
      ], 200);
    } catch (Throwable $th) {
      return response($th, 500);
    }
  }
}
