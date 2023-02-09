<?php

namespace App\Http\Controllers;

use App\Models\Product as ModelsProduct;
use App\Models\Task as ModelsTask;
use App\Services\Utils as ServicesUtils;
use Illuminate\Http\JsonResponse;

class UtilsController extends Controller
{
  public function generateArticle(string $type, ServicesUtils $servicesUtils): JsonResponse
  {
    $response = [];
    switch ($type) {
      case 'product':
        $response = $servicesUtils->generateProductArticle();
        break;
      case 'task':
        $response = $servicesUtils->generateTaskArticle();
        break;
      default:
    }
    return response()->json(['article' => $response], 200);
  }

  public function generateZoneLetter(ServicesUtils $servicesUtils): JsonResponse
  {
    $response = $servicesUtils->generateZoneLetter();

    return response()->json(['letter' => $response], 200);
  }
}
