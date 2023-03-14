<?php

namespace App\Actions\Links;

use App\Models\ProductPoint as ModelsProductPoint;
use Throwable;

class ProductPoint
{
  public function add(array $productIds, array $pointIds)
  {
    foreach ($productIds as $productId) {
      foreach ($pointIds as $pointId) {
      }
      $productFloor = new ModelsProductPoint();
      $productFloor->product_id = $productId;
      $productFloor->point_id = $pointIds[0];
      $productFloor->save();
    }
  }

  public function deleteByProductIds(array $productIds)
  {
    ModelsProductPoint::whereIn('product_id', $productIds)->delete();
  }

  public function getIdsProductAndIdsPoint()
  {
    $productsPoints = ModelsProductPoint::select('product_id', 'point_id')->get();
    return $productsPoints;
  }

  public function getPointIdsByProductIds(array $productIds)
  {
    $idsProductWithLinkToPoint = $this->getIdsProductAndIdsPoint();

    $pointIds = [];
    foreach ($productIds as $productId) {
      if ($idsProductWithLinkToPoint->contains('product_id', $productId)) {
        $pointIds = array_merge($pointIds, $idsProductWithLinkToPoint
          ->where('product_id', $productId)
          ->pluck('point_id')
          ->toArray());
      }
    }

    return $pointIds;
  }
}
