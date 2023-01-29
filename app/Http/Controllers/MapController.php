<?php

namespace App\Http\Controllers;

use App\Services\Map as ServicesMap;
use Illuminate\Http\Request;
use Throwable;

class MapController extends Controller
{
  public function index(
    ServicesMap $servicesMap,
  ) {
    try {
      $response = $servicesMap->index();

      return response()->json($response, 200);
    } catch (Throwable $th) {
      return response($th, 500);
    }
  }

  public function update(
    ServicesMap $servicesMap,
    Request $request,
  ) {
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
  ) {
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
