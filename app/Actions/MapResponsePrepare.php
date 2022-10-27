<?php

namespace App\Actions;

use Exception;
use Illuminate\Database\Eloquent\Collection;

class MapResponsePrepare
{

  public function __invoke(Collection $zones, Collection $sections, Collection $blocks, Collection $floors)
  {
    $response = [];

    foreach ($zones as $zone) {
      $sections = $zone->sections;
      if (count($sections) > 0) {
        array_push($response, [
          'id' => $zone->id,
          'zoneLetter' => $zone->letter,
          'sections' => [],
        ]);

        foreach ($sections as $section) {
          $blocks = $section->blocks;
          if (count($blocks) > 0) {
            $lastIndexZone = count($response) - 1;
            array_push($response[$lastIndexZone]['sections'], [
              'id' => $section->id,
              'blocks' => [],
            ]);

            foreach ($blocks as $block) {
              $floors = $block->floors;
              if (count($floors) > 0) {
                $lastIndexSection = count($response[$lastIndexZone]['sections']) - 1;
                array_push($response[$lastIndexZone]['sections'][$lastIndexSection]['blocks'], [
                  'id' => $block->id,
                  'floors' => []
                ]);

                foreach ($floors as $floor) {
                  $lastIndexBlock = count($response[$lastIndexZone]['sections'][$lastIndexSection]['blocks']) - 1;
                  array_push($response[$lastIndexZone]['sections'][$lastIndexSection]['blocks'][$lastIndexBlock]['floors'], [
                    'id' => $floor->id,
                  ]);
                }
              }
            }
          }
        }
      }
    }

    return $response;
  }
}
