<?php

namespace App\Http\Controllers;

use App\Services\ProductType as ServicesProductType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class ProductTypeController extends Controller
{
  public function index(ServicesProductType $service): JsonResponse | Response
  {
    try {
      $response = $service->index();

      return response()->json($response, 200);
    } catch (Throwable $th) {
      return response($th, 500);
    }
  }
}
