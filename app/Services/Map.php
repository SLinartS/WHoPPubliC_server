<?php

namespace App\Services;

use App\Actions\ResponsePrepare\Map as ResponsePrepareMap;
use App\Models\Block as ModelsBlock;
use App\Models\Floor as ModelsFloor;
use App\Models\Section as ModelsSection;
use App\Models\Zone as ModelsZone;

class Map
{
  public function index()
  {
    $zones = ModelsZone::select('id', 'number', 'letter')->get();
    $sections = ModelsSection::select('id', 'number', 'zone_id')->get();
    $blocks = ModelsBlock::select('id', 'number', 'section_id')->get();
    $floors = ModelsFloor::select('id', 'number', 'block_id', 'capacity')->get();

    return (new ResponsePrepareMap())(
      $zones,
      $sections,
      $blocks,
      $floors
    );
  }
}
