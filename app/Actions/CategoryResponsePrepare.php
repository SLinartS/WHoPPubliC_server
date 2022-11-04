<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Collection;

class CategoryResponsePrepare
{

  public function __invoke(Collection $categories)
  {
    $response = [];

    foreach ($categories as $category) {
      array_push($response, [
        'id' => $category->id,
        'title' => $category->title,
      ]);
    }

    return $response;
  }
}
