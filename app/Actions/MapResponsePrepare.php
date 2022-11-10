<?php

namespace App\Actions;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class MapResponsePrepare
{

  public function __invoke(
    Collection $zones,
    Collection $sections,
    Collection $blocks,
    Collection $floors,
    Collection $productsFloors,
    Collection $products
  ) {
    $response = [];
    $localProductsFloors = $productsFloors;
    $localProducts = $products;

    foreach ($zones as $zone) {
      $sections = $zone->sections;
      if (count($sections) > 0) {
        array_push($response, [
          'id' => $zone->id,
          'number' => $zone->number,
          'zoneLetter' => $zone->letter,
          'sections' => [],
        ]);

        foreach ($sections as $section) {
          $blocks = $section->blocks;
          if (count($blocks) > 0) {
            $lastIndexZone = count($response) - 1;
            array_push($response[$lastIndexZone]['sections'], [
              'id' => $section->id,
              'number' => $section->number,
              'blocks' => [],
            ]);

            foreach ($blocks as $block) {
              $floors = $block->floors;
              if (count($floors) > 0) {
                $lastIndexSection = count($response[$lastIndexZone]['sections']) - 1;
                array_push($response[$lastIndexZone]['sections'][$lastIndexSection]['blocks'], [
                  'id' => $block->id,
                  'number' => $block->number,
                  'floors' => []
                ]);

                foreach ($floors as $floor) {
                  $freeFloorSpace = $this->countFreeFloorSpace($localProductsFloors, $localProducts, $floor);

                  $lastIndexBlock = count($response[$lastIndexZone]['sections'][$lastIndexSection]['blocks']) - 1;
                  array_push($response[$lastIndexZone]['sections'][$lastIndexSection]['blocks'][$lastIndexBlock]['floors'], [
                    'id' => $floor->id,
                    'active' => false,
                    'number' => $floor->number,
                    'capacity' => $floor->capacity,
                    'freeSpace' => $freeFloorSpace,
                  ]);
                }
              }
            }
          }
        }
      }
    }

    $response = $this->sortMap($response);
    return $response;
  }

  private function sortMap(array $response)
  {
    usort($response, fn ($a, $b) => $a['number'] - $b['number']);

    for ($iz = 0; $iz < count($response); $iz++) {
      usort($response[$iz]['sections'], fn ($a, $b) => $a['number'] - $b['number']);

      for ($is = 0; $is < count($response[0]['sections']); $is++) {
        usort($response[$iz]['sections'][$is]['blocks'], fn ($a, $b) => $a['number'] - $b['number']);

        for ($ib = 0; $ib < count($response[0]['sections'][0]['blocks']); $ib++) {
          usort($response[$iz]['sections'][$is]['blocks'][$ib]['floors'], fn ($a, $b) => $b['number'] - $a['number']);
        }
      }
    }
    return $response;
  }

  private function countFreeFloorSpace(
    Collection $localProductsFloors,
    Collection $localProducts,
    Model $floor,
  ) {
    $freeFloorSpace = $floor->capacity;
    foreach ($localProductsFloors as $productFloor) {
      if ($productFloor->floor_id === $floor->id) {
        foreach ($localProducts as $localProduct) {
          if ($localProduct['id'] === $productFloor->product_id) {
            $freeFloorSpace = $floor->capacity - $localProduct['number'];
          }
        }
      }
    }

    return $freeFloorSpace;
  }
}
