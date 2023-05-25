<?php

namespace App\Http\Controllers;

use App\Services\Audience as ServicesAudience;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class AudienceController extends Controller
{
  public function index(ServicesAudience $service): JsonResponse | Response
  {
    try {
      $response = $service->index();

      return response()->json($response, 200);
    } catch (Throwable $th) {
      return response($th, 500);
    }
  }
}
