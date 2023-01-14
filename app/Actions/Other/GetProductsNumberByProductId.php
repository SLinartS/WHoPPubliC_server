<?php

namespace App\Actions\Other;

use App\Models\Product;

class GetProductsNumberByProductId
{
  public function __invoke(array $productIds)
  {
    $products = Product::select('id', 'number')
      ->whereIn('id', $productIds)
      ->get();

    return $products;
  }
}
