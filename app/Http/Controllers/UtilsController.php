<?php

namespace App\Http\Controllers;

use App\Models\Product as ModelsProduct;
use App\Models\Task as ModelsTask;
use Illuminate\Http\JsonResponse;

class UtilsController extends Controller
{
  public function checkArticle(string $type, string $article): JsonResponse
  {
    $response = [];
    switch ($type) {
      case 'product':
        $response = ModelsProduct::where('article', $article)->get();
        break;
      case 'task':
        $response = ModelsTask::where('article', $article)->get();
        break;

      default:
    }
    if ($response->count() === 0) {
      return response()->json(['isActionExist' => false]);
    }
    return response()->json(['isActionExist' => true]);
  }
}
