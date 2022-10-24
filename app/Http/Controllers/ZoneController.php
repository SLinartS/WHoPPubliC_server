<?php

namespace App\Http\Controllers;

use App\Actions\ZoneResponsePrepare;
use App\Models\Block;
use App\Models\Floor;
use App\Models\Section;
use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function index(ZoneResponsePrepare $zoneResponsePrepare)
    {
        $zones = Zone::select('id', 'letter')->get();
        $sections = Section::select('id', 'zone_id')->get();
        $blocks = Block::select('id', 'section_id')->get();
        $floors = Floor::select('id', 'block_id')->get();

        $response = $zoneResponsePrepare($zones, $sections, $blocks, $floors);

        return response()->json($response, 200);
    }
}
