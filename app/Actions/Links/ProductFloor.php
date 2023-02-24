<?php

namespace App\Actions\Links;

use App\Actions\Other\CountFreeFloorSpace;
use App\Models\Product;
use App\Models\ProductFloor as ModelsProductFloor;
use Illuminate\Database\Eloquent\Collection;

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
    $productFloor->is_actual = false;
    $productFloor->save();
  }

  public function deleteByProductIds(array $productIds, bool $isActual = null)
  {
    if ($isActual) {
      ModelsProductFloor::whereIn('product_id', $productIds)
        ->where('is_actual', $isActual)
        ->delete();
    } else {
      ModelsProductFloor::whereIn('product_id', $productIds)->delete();
    }
  }

  public function getProductIdsAndFloorIds()
  {
    $productsFloors = ModelsProductFloor::select('product_id', 'floor_id', 'is_actual')->get();
    return $productsFloors;
  }

  public function getFloorIdsInfoByProductId(int $productId)
  {
    $idsProductWithLinkToFloor = $this->getProductIdsAndFloorIds($productId);

    $floorIds = [];
    $actualFloorIds = [];
    if ($idsProductWithLinkToFloor->contains('product_id', $productId)) {
      $floorIds = $idsProductWithLinkToFloor
        ->where('product_id', $productId)
        ->pluck('floor_id')
        ->toArray();
      $actualFloorIds = $idsProductWithLinkToFloor
        ->where('product_id', $productId)
        ->where('is_actual', true)
        ->pluck('floor_id')
        ->toArray();
    }

    return [ 'floorIds' => $floorIds, 'actualFloorIds' => $actualFloorIds ];
  }

  public function setPositionAsActual(int $productId)
  {
    $modelsProductFloor = ModelsProductFloor::where('product_id', $productId)->first();

    $modelsProductFloor->is_actual = true;
  }

  public function getFloorIdsByProductIds(array $productIds): array
  {
    $floorIds = ModelsProductFloor::select('floor_id')
      ->whereIn('product_id', $productIds)
      ->get()
      ->pluck('floor_id')
      ->toArray();

    return $floorIds;
  }

  public function getFloorInfoByProductIds(array $productIds): Collection
  {
    $floorInfo = ModelsProductFloor::select('floor_id', 'occupied_space')
      ->whereIn('product_id', $productIds)
      ->get();

    return $floorInfo;
  }

  public static function getProductIdsByFloorIds(array $floorIds): array
  {
    $productIds = ModelsProductFloor::select('product_id')
      ->whereIn('floor_id', $floorIds)
      ->get()
      ->pluck('product_id')
      ->toArray();

    return $productIds;
  }
}
