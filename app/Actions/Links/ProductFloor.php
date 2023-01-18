<?php

namespace App\Actions\Links;

use App\Actions\Other\CountFreeFloorSpace;
use App\Models\Product;
use App\Models\ProductFloor as ModelsProductFloor;

class ProductFloor
{
  public function index()
  {
    $productsFloors = ModelsProductFloor::select('product_id', 'floor_id')->get();
    return $productsFloors;
  }

  public function add(array $productIds, array $floorIds)
  {
    for ($productIndex = 0; $productIndex < count($productIds); $productIndex++) {
      $productId = $productIds[$productIndex];
      $initialNumberOfProduct = $numberOfProduct = Product::select('number')->where('id', $productId)->first()->number;
      $addedNumberOfProduct = 0;

      $indexOfFloor = 0;
      while ($indexOfFloor < count($floorIds)) {
        $floorId = $floorIds[$indexOfFloor];
        $freeSpaceOfFloor = (new CountFreeFloorSpace())($floorId);

        if ($freeSpaceOfFloor === 0) {
          $indexOfFloor++;
          continue;
        }

        if ($initialNumberOfProduct <= $freeSpaceOfFloor) {
          $this->addLink($productId, $floorId, $initialNumberOfProduct - $addedNumberOfProduct);
          break;
        } elseif ($numberOfProduct <= $freeSpaceOfFloor) {
          $this->addLink($productId, $floorId, $numberOfProduct);
          $addedNumberOfProduct += $numberOfProduct;
          if ($addedNumberOfProduct === $initialNumberOfProduct) {
            break;
          }
          $numberOfProduct = $initialNumberOfProduct - $addedNumberOfProduct;
          $indexOfFloor++;
        } else {
          $numberOfProduct = $freeSpaceOfFloor;
        }
      }
    }
  }

  private function addLink(int $productId, int $floorId, int $occupiedSpace)
  {
    $productFloor = new ModelsProductFloor();
    $productFloor->product_id = $productId;
    $productFloor->floor_id = $floorId;
    $productFloor->occupied_space = $occupiedSpace;
    $productFloor->save();
  }

  public function deleteByProductIds(array $productIds)
  {
    ModelsProductFloor::whereIn('product_id', $productIds)->delete();
  }

  public function getProductIdsAndFloorIds()
  {
    $productsFloors = ModelsProductFloor::select('product_id', 'floor_id')->get();
    return $productsFloors;
  }

  public function getFloorIdsByProductId(int $productId)
  {
    $idsProductWithLinkToFloor = $this->getProductIdsAndFloorIds($productId);

    $isLinkedToFloors = false;
    $floorIds = [];
    if ($idsProductWithLinkToFloor->contains('product_id', $productId)) {
      $isLinkedToFloors = true;
      $floorIds = $idsProductWithLinkToFloor
        ->where('product_id', $productId)
        ->pluck('floor_id')
        ->toArray();
    }

    return ['isLinkedToFloors' => $isLinkedToFloors, 'floorIds' => $floorIds];
  }
}
