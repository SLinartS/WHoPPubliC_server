<?php

namespace App\Http\Controllers;

use App\Services\Category as ServicesCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class CategoryController extends Controller
{
  public function index(ServicesCategory $service): JsonResponse | Response
  {
    try {
      $response = $service->index();

      return response()->json($response, 200);
    } catch (Throwable $th) {
      return response($th, 500);
    }
  }
}
