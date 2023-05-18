<?php

namespace App\Http\Controllers;

use App\Services\FileType as ServicesFileType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class TypeOfFileController extends Controller
{
  public function index(ServicesFileType $service): JsonResponse | Response
  {
    try {
      $response = $service->index();

      return response()->json($response, 200);
    } catch (Throwable $th) {
      return response($th, 500);
    }
  }
}
