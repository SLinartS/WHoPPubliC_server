<?php

namespace App\Actions\ResponsePrepare;

use App\Actions\Links\ProductFloor as LinksProductFloor;
use App\Actions\Links\ProductPoint as LinksProductPoint;
use App\Actions\Links\ProductTask as LinksProductTask;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Arabic;

class Product
{
  public function __invoke(array $products)
  {
    $response = [
      'data' => [],
      'serviceInformation' => [],
    ];

    foreach ($products as $product) {
      $item = $this->formateProduct($product);

      $taskId = (new LinksProductTask())->getTaskIdByProductId($product['id']);
      $pointIds = (new LinksProductPoint())->getPointIdsByProductIds([$product['id']]);
      ['floorIds' => $floorIds, 'actualFloorIds' => $actualFloorIds] = (new LinksProductFloor())->getFloorIdsInfoByProductId($product['id']);

      $serviceInformation = [
        'productId' => $product['id'],
        'taskId' => $taskId,
        'floorIds' => $floorIds,
        'actualFloorIds' => $actualFloorIds,
        'pointIds' => $pointIds
      ];

      array_push($response['serviceInformation'], $serviceInformation);
      array_push($response['data'], $item);
    }

    return $response;
  }

  public function oneProduct(array $product)
  {
    $formattedProduct = [];

    $taskId = (new LinksProductTask())->getTaskIdByProductId($product['id']);
    $pointIds = (new LinksProductPoint())->getPointIdsByProductIds([$product['id']]);
    ['floorIds' => $floorIds, 'actualFloorIds' => $actualFloorIds] = (new LinksProductFloor())->getFloorIdsInfoByProductId($product['id']);

    $formattedProduct = $this->formateProduct($product);

    $response = [
      'productInfo' => $formattedProduct,
      'pointId' => $product['point_id'],
      'serviceInformation' => [
        'taskId' => $taskId,
        'floorIds' => $floorIds,
        'actualFloorIds' => $actualFloorIds,
        'pointIds' => $pointIds
      ]
    ];

    return $response;
  }

  private function formateProduct(array $product): array
  {
    $formattedProductInfo = [
      'id' => [
        'value' =>  $product['id'],
        'alias' => "ID"
      ],
      'article' => [
        'value' =>  $product['article'],
        'alias' => "Артикул"
      ],
      'title' => [
        'value' =>  $product['title'],
        'alias' => "Название"
      ],
      'number' => [
        'value' => $product['number'],
        'alias' => "Количество"
      ],
      'imageUrl' => [
        'value' => ($product['image_url']) ? Storage::url($product['image_url']) : null,
        'alias' => "Image_url"
      ],
      'note' => [
        'value' =>  $product['note'],
        'alias' => "Примечание"
      ],
      'categoryId' => [
        'value' => $product['category_id'],
        'alias' => "Category_id"
      ],
      'categoryAlias' => [
        'value' => $product['category_alias'],
        'alias' => "Категория"
      ],
      'typeId' => [
        'value' => $product['product_type_id'],
        'alias' => "Product_type_id"
      ],
      'typeAlias' => [
        'value' => $product['type_alias'],
        'alias' => "Тип"
      ],
    ];

    $additionalInformation = [];

    switch ($product['product_type_id']) {
      case 1:
        $additionalInformation = [
          'author' => [
            'value' => $product['author'],
            'alias' => "Автор"
          ],
          'yearOfPublication' => [
            'value' => $product['year_of_publication'],
            'alias' => "Год публикации"
          ],
          'yearOfPrinting' => [
            'value' => $product['year_of_printing'],
            'alias' => "Год печати"
          ],
          'printingHouse' => [
            'value' => $product['printing_house'],
            'alias' => "Типография"
          ],
          'publishingHouse' => [
            'value' => $product['publishing_house'],
            'alias' => "Издательство"
          ],
        ];
        break;
      case 2:
        $additionalInformation = [
          'printingHouse' => [
            'value' => $product['printing_house'],
            'alias' => "Типография"
          ],
          'publishingHouse' => [
            'value' => $product['publishing_house'],
            'alias' => "Издательство"
          ],
          'dateOfPrinting' => [
            'value' => $this->formateProductDate($product['date_of_printing']),
            'alias' => "Дата печати"
          ],
          'regularityId' => [
            'value' => $product['regularity_id'],
            'alias' => "regularity_id"
          ],
          'regularityAlias' => [
            'value' => $product['regularity_alias'],
            'alias' => "Регулярность"
          ],
          'audienceId' => [
            'value' => $product['audience_id'],
            'alias' => "audience_id"
          ],
          'audienceAlias' => [
            'value' => $product['audience_alias'],
            'alias' => "Аудитория"
          ],
        ];
        break;
      default:
    }

    return  array_merge($formattedProductInfo, $additionalInformation);
  }

  private function formateProductDate(string $date)
  {
    $dateTime = strtotime($date);
    $formattedTime = date('d.m.Y', $dateTime);
    return $formattedTime;
  }
}
