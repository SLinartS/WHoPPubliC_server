<?php

namespace App\Actions\Other;

use App\Models\Product;

class GetProductIdByArticle
{
  public function __invoke(string $article): int
  {
    $productId = Product::select('id')->where('article', $article)->first()['id'];

    return $productId;
  }
}
