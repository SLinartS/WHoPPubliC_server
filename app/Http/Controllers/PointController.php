<?php

namespace App\Http\Controllers;

use App\Services\Point as ServicesPoint;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class PointController extends Controller
{
  public function index(ServicesPoint $service): JsonResponse | Response
  {
    try {
      $response = $service->index();

      return response()->json($response, 200);
    } catch (Throwable $th) {
      return response($th, 500);
    }
  }
}
