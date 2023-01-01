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
      'tableHeader' => [],
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
        'printingHouse' => $product->printing_house,
        'publishingHouse' => $product->publishing_house,
        'categoryId' => $product->category_id,
        'categoryTitle' => $product->category_title,
      ];

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

    $response['tableHeader'] = [
      'ID',
      'Артикул',
      'Название',
      'Автор',
      'Год издания',
      'Количество',
      'Дата печати',
      'Типография',
      'Издательство',
      'Категория_id',
      'Категория_title',
    ];

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

    foreach ($product->toArray() as $key => $productField) {
      switch ($key) {
        case "year_of_publication":
          $formatedProduct['yearOfPublication'] = $productField;
          break;
        case "print_date":
          $formatedProduct['printDate'] = $productField;
          break;
        case "printing_house":
          $formatedProduct['printingHouse'] = $productField;
          break;
        case "publishing_house":
          $formatedProduct['publishingHouse'] = $productField;
          break;
        case "category_id":
          $formatedProduct["categoryId"] = $productField;
          break;
        case "category_title":
          $formatedProduct["categoryTitle"] = $productField;
          break;
        case "point_id":
          break;
        default:
          $formatedProduct[$key] = $productField;
      }
    }

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
}
