<?php

namespace App\Http\Controllers;

use App\Services\Map as ServicesMap;
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
}
