<?php

namespace App\Actions\ResponsePrepare;

use Illuminate\Database\Eloquent\Collection;

class Category
{
  public function __invoke(Collection $categories)
  {
    $response = [];

    foreach ($categories as $category) {
      array_push($response, [
        'id' => $category->id,
        'title' => $category->title,
        'productType' => $category->productType,
      ]);
    }

    return $response;
  }
}
