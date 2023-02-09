<?php

namespace App\Http\Controllers;

use App\Models\Product as ModelsProduct;
use App\Models\Task as ModelsTask;
use App\Services\Utils as ServicesUtils;
use Illuminate\Http\JsonResponse;

class UtilsController extends Controller
{
  public function generateArticle(string $type): JsonResponse
  {
    $response = [];
    switch ($type) {
      case 'product':
        $response = (new ServicesUtils)->generateProductArticle();
        break;
      case 'task':
        $response = (new ServicesUtils)->generateTaskArticle();
        break;
      default:
    }
    return response()->json(['article' => $response], 200);
  }
}
