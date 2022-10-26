<?php

namespace App\Actions;

use Exception;
use Illuminate\Database\Eloquent\Collection;

class MapResponsePrepare
{

  public function __invoke(Collection $zones, Collection $sections, Collection $blocks, Collection $floors)
  {
    $response = [];

    foreach ($zones as $zoneKey => $zone) {
      $sections = $zone->sections;
      if (count($sections) > 0) {
        array_push($response, [
          'id' => $zone->id,
          'zoneLetter' => $zone->letter,
          'sections' => [],
        ]);

        foreach ($sections as $sectionKey => $section) {
          $blocks = $section->blocks;
          if (count($blocks) > 0) {
            $lastIndexZone = count($response)-1;
            array_push($response[$lastIndexZone]['sections'], [
              'id' => $section->id,
              'floorsNumber' => 0,
              'blocks' => [],
            ]);

            foreach ($blocks as $blockKey => $block) {

              $lastIndexSection = count($response[$lastIndexZone]['sections'])-1;
              array_push($response[$lastIndexZone]['sections'][$lastIndexSection]['blocks'], [
                'id' => $block->id,
              ]);
              $response[$lastIndexZone]['sections'][$lastIndexSection]['floorsNumber'] = count($block->floors);
            }
          }
        }
      }
    }

    return $response;
  }
}
