<?php

namespace App\Http\Controllers;

use App\Services\Category as ServicesCategory;
use Throwable;

class CategoryController extends Controller
{
  public function index(ServicesCategory $categoryServices)
  {
    try {
      $response = $categoryServices->index();

      return response()->json($response, 200);
    } catch (Throwable $th) {
      response($th, 500);
    }
  }
}
