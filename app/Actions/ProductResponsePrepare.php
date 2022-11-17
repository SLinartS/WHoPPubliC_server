<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Collection;

class ProductResponsePrepare
{

  public function __invoke(Collection $products)
  {
    $response = [
      'data' => [],
      'tableHeader' => []
    ];

    foreach ($products as $product) {
      $item = [
        'id' => $product->id,
        'article' => $product->article,
        'title' => $product->title,
        'author' => $product->author,
        'category' => $product->category,
        'number' => $product->number,
        'printDate' => $product->print_date,

      ];

      array_push($response['data'], $item);
    }

    $response['tableHeader'] = [
      'ID',
      'Артикул',
      'Название',
      'Автор',
      'Категория',
      'Количество',
      'Дата печати',
    ];

    return $response;
  }
}
