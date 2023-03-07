<?php

namespace App\Actions\ResponsePrepare;

use App\Actions\Links\ProductFloor;
use App\Actions\Other\CountFreeFloorSpace;
use App\Actions\Other\CountReservedFloorSpace;
use App\Actions\Other\SearchProducts;
use Illuminate\Database\Eloquent\Collection;

class Map
{
  public function __invoke(
    Collection $zones,
    Collection $sections,
    Collection $blocks,
    Collection $floors,
    string | null $search
  ) {
    $response = [];

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
                  $freeFloorSpace = (new CountFreeFloorSpace())($floor->id);
                  $reservedFloorSpace = (new CountReservedFloorSpace())($floor->id);

                  $lastIndexBlock = count($response[$lastIndexZone]['sections'][$lastIndexSection]['blocks']) - 1;
                  array_push($response[$lastIndexZone]['sections'][$lastIndexSection]['blocks'][$lastIndexBlock]['floors'], [
                    'id' => $floor->id,
                    'number' => $floor->number,
                    'capacity' => $floor->capacity,
                    'freeSpace' => $freeFloorSpace,
                    'reservedSpace' => $reservedFloorSpace,
                    'isSearch' => false,
                    'productIds' => [],
                  ]);

                  $responseFloorIndex = count($response[$lastIndexZone]['sections'][$lastIndexSection]['blocks'][$lastIndexBlock]['floors']) - 1;

                  if ($search) {
                    $productIds = (new SearchProducts())([$floor->id], $search);
                    if (count($productIds)) {
                      $response[$lastIndexZone]['sections'][$lastIndexSection]['blocks'][$lastIndexBlock]['floors'][$responseFloorIndex]['isSearch'] = true;
                    }
                  } else {
                    $productIds = (new ProductFloor())->getProductIdsByFloorIds([$floor->id]);
                  }

                  $response[$lastIndexZone]['sections'][$lastIndexSection]['blocks'][$lastIndexBlock]['floors'][$responseFloorIndex]['productIds'] = $productIds;
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

      for ($is = 0; $is < count($response[$iz]['sections']); $is++) {
        usort($response[$iz]['sections'][$is]['blocks'], fn ($a, $b) => $a['number'] - $b['number']);

        for ($ib = 0; $ib < count($response[$iz]['sections'][$is]['blocks']); $ib++) {
          usort($response[$iz]['sections'][$is]['blocks'][$ib]['floors'], fn ($a, $b) => $b['number'] - $a['number']);
        }
      }
    }
    return $response;
  }
}
