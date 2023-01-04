<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductResponsePrepare
{

  public function __invoke(Collection $products, Collection $idsProductWithLinkToTask)
  {
    $response = [
      'data' => [],
      'serviceInformation' => [],
    ];

    foreach ($products as $product) {

      $item = $this->formateProduct($product);

      $isLinkedToTask = false;
      $taskId = 0;
      if ($idsProductWithLinkToTask->contains('product_id', $product->id)) {
        $isLinkedToTask = true;
        $taskId = $idsProductWithLinkToTask->firstWhere('product_id', $product->id)['task_id'];
      }
      $serviceInformation = [
        'productId' => $product->id,
        'isLinkedToTask' => $isLinkedToTask,
        'taskId' => $taskId
      ];

      array_push($response['serviceInformation'], $serviceInformation);
      array_push($response['data'], $item);
    }

    return $response;
  }

  public function oneProduct(Model $product, Collection $idsProductWithLinkToTask)
  {
    $formatedProduct = [];

    $isLinkedToTask = false;
    $taskId = 0;
    if ($idsProductWithLinkToTask->contains('product_id', $product->id)) {
      $isLinkedToTask = true;
      $taskId = $idsProductWithLinkToTask->firstWhere('product_id', $product->id)['task_id'];
    }

    $formatedProduct = $this->formateProduct($product);

    $response = [
      'productInfo' => $formatedProduct,
      'pointId' => $product->point_id,
      'serviceInformation' => [
        'isLinkedToTask' => $isLinkedToTask,
        'taskId' => $taskId
      ]
    ];

    return $response;
  }


  private function formateProduct(Model $product): array
  {
    return  [
      'id' => [
        'value' =>  $product->id,
        'alias' => "ID"
      ],
      'article' => [
        'value' =>  $product->article,
        'alias' => "Артикль"
      ],
      'title' => [
        'value' =>  $product->title,
        'alias' => "Название"
      ],
      'author' => [
        'value' => $product->author,
        'alias' => "Автор"
      ],
      'yearOfPublication' => [
        'value' => $product->year_of_publication,
        'alias' => "Год публикации"
      ],
      'number' => [
        'value' => $product->number,
        'alias' => "Количество"
      ],
      'printDate' => [
        'value' => $product->print_date,
        'alias' => "Дата печати"
      ],
      'printingHouse' => [
        'value' => $product->printing_house,
        'alias' => "Типография"
      ],
      'publishingHouse' => [
        'value' => $product->publishing_house,
        'alias' => "Издательство"
      ],
      'categoryId' => [
        'value' => $product->category_id,
        'alias' => "Category_id"
      ],
      'categoryTitle' => [
        'value' => $product->category_title,
        'alias' => "Категория"
      ],
    ];
  }
}
