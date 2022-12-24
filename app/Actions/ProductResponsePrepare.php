<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Collection;

class ProductResponsePrepare
{

  public function __invoke(Collection $products, Collection $idsProductWithLinkToTask)
  {
    $response = [
      'data' => [],
      'serviceInformation' => [],
      'tableHeader' => [],
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

      $isLinkedToTask = false;
      $taskId = 0;
      if ($idsProductWithLinkToTask->contains('product_id', $product->id)) {
        $isLinkedToTask = true;
        $taskId = $idsProductWithLinkToTask->firstWhere('product_id')['task_id'];
      }
      $serviceInformation = [
        'productId' => $product->id,
        'isLinkedToTask' => $isLinkedToTask,
        'taskId' => $taskId
      ];

      array_push($response['serviceInformation'], $serviceInformation);
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
