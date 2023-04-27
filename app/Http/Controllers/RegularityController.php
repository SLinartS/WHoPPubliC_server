<?php

namespace App\Http\Controllers;

use App\Services\Regularity as ServicesRegularity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class RegularityController extends Controller
{
  public function index(ServicesRegularity $service): JsonResponse | Response
  {
    try {
      $response = $service->index();

      return response()->json($response, 200);
    } catch (Throwable $th) {
      return response($th, 500);
    }
  }
}
