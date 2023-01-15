<?php

namespace App\Actions\ResponsePrepare;

use App\Actions\Links\ProductFloor as LinksProductFloor;
use App\Actions\Links\ProductTask as LinksProductTask;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Product
{
  public function __invoke(Collection $products)
  {
    $response = [
      'data' => [],
      'serviceInformation' => [],
    ];

    foreach ($products as $product) {
      $item = $this->formateProduct($product);

      ['isLinkedToTask' => $isLinkedToTask, 'taskId' => $taskId] = (new LinksProductTask())->getTaskIdByProductId($product->id);
      ['isLinkedToFloors' => $isLinkedToFloors, 'floorIds' => $floorIds] = (new LinksProductFloor())->getFloorIdsByProductId($product->id);

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

  public function oneProduct(Model $product)
  {
    $formatedProduct = [];

    ['isLinkedToTask' => $isLinkedToTask, 'taskId' => $taskId] = (new LinksProductTask())->getTaskIdByProductId($product->id);
    ['isLinkedToFloors' => $isLinkedToFloors, 'floorIds' => $floorIds] = (new LinksProductFloor())->getFloorIdsByProductId($product->id);

    $formatedProduct = $this->formateProduct($product);

    $response = [
      'productInfo' => $formatedProduct,
      'pointId' => $product->point_id,
      'serviceInformation' => [
        'isLinkedToTask' => $isLinkedToTask,
        'taskId' => $taskId,
        'isLinkedFloors' => $isLinkedToFloors,
        'floorIds' => $floorIds
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
