<?php

namespace App\Http\Controllers;

use App\Services\Point as ServicesPoint;
use Throwable;

class PointController extends Controller
{
  public function index(ServicesPoint $servicesPoint)
  {
    try {
      $response = $servicesPoint->index();

      return response()->json($response, 200);
    } catch (Throwable $th) {
      return response($th, 500);
    }
  }
}
