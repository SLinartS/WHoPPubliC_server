<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Collection;

class ZoneResponsePrepare
{

  public function __invoke(Collection $zones, Collection $sections, Collection $blocks, Collection $floors)
  {
    $response = [];
    
    foreach ($zones as $zoneKey => $zone) {
      array_push($response, [
        'id' => $zone->id,
        'zoneLetter' => $zone->letter,
        'sections' => [],
      ]);
      $sections = $zone->sections;

      foreach ($sections as $sectionKey => $section) {
        array_push($response[$zoneKey]['sections'], [
          'id' => $section->id,
          'floorsNumber' => 0,
          'blocks' => [],
        ]);
        $blocks = $section->blocks;

        foreach ($blocks as $blockKey => $block) {
          array_push($response[$zoneKey]['sections'][$sectionKey]['blocks'], [
            'id' => $block->id,
          ]);
          $response[$zoneKey]['sections'][$sectionKey]['floorsNumber'] = count($block->floors); 
        }
      }
    }

    return $response;
  }
}
