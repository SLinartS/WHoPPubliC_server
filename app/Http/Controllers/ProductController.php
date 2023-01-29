<?php

namespace App\Http\Controllers;

use App\Services\Product as ServicesProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class ProductController extends Controller
{
  public function index(ServicesProduct $servicesProduct): JsonResponse | Response
  {
    try {
      $response = $servicesProduct->index();

      return response()->json($response, 200);
    } catch (Throwable $th) {
      return response($th, 500);
    }
  }

  public function show(
    int $productId,
    ServicesProduct $servicesProduct
  ): JsonResponse | Response {
    try {
      $response = $servicesProduct->show($productId);

      return response()->json($response, 200);
    } catch (Throwable $th) {
      return response($th, 500);
    }
  }

  public function store(
    Request $request,
    ServicesProduct $servicesProduct
  ): JsonResponse | Response {
    try {
      $fields = $request->fields;
      $userId = $request->userId;
      $pointId = $request->pointId;
      $servicesProduct->store(
        $fields,
        $userId,
        $pointId,
      );

      return response()->json([
        'message' => 'The products has been added'
      ], 200);
    } catch (Throwable $th) {
      return response($th, 500);
    }
  }

  public function update(
    Request $request,
    ServicesProduct $servicesProduct
  ): JsonResponse | Response {
    try {
      $fields = $request->fields;
      $userId = $request->userId;
      $pointId = $request->pointId;
      $servicesProduct->update($fields, $userId, $pointId);

      return response()->json([
        'message' => 'The products has been changed'
      ], 200);
    } catch (Throwable $th) {
      return response($th, 500);
    }
  }

  public function destroy(
    string $productId,
    ServicesProduct $servicesProduct
  ): JsonResponse | Response {
    try {
      $servicesProduct->destroy([$productId]);

      return response()->json([
        'message' => 'The products has been deleted'
      ], 200);
    } catch (Throwable $th) {
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }

  public function markAsMoved(
    Request $request,
    ServicesProduct $servicesProduct
  ): JsonResponse | Response {
    try {
      $productId = $request->productId;
      $servicesProduct->markAsMoved($productId);

      return response()->json([
        'message' => 'The products has been marked as moved'
      ], 200);
    } catch (Throwable $th) {
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }
}
