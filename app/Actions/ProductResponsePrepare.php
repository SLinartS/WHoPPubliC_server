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
        'yearOfPublication' => $product->year_of_publication,
        'number' => $product->number,
        'printDate' => $product->print_date,
        'category' => $product->category,
      ];

      array_push($response['data'], $item);
    }

    $response['tableHeader'] = [
      'ID',
      'Артикул',
      'Название',
      'Автор',
      'Год',
      'Число',
      'Дата печати',
      'Категория'
    ];

    return $response;
  }
}
