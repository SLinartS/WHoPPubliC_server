<?php

namespace App\Actions\Links;

use App\Models\ProductPoint as ModelsProductPoint;
use Throwable;

class ProductPoint
{
  public function add(int $productId, int $pointId)
  {
    $productFloor = new ModelsProductPoint();
    $productFloor->product_id = $productId;
    $productFloor->point_id = $pointId;
    $productFloor->save();
  }

  public function deleteByProductId(array $productIds)
  {
    ModelsProductPoint::whereIn('product_id', $productIds)->delete();
  }
}
