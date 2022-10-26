<?php

namespace App\Http\Controllers;

use App\Actions\MapResponsePrepare;
use App\Models\Block;
use App\Models\Floor;
use App\Models\Section;
use App\Models\Zone;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index(MapResponsePrepare $mapResponsePrepare)
    {
        $zones = Zone::select('id', 'letter')->get();
        $sections = Section::select('id', 'zone_id')->get();
        $blocks = Block::select('id', 'section_id')->get();
        $floors = Floor::select('id', 'block_id')->get();

        $response = $mapResponsePrepare($zones, $sections, $blocks, $floors);

        return response()->json($response, 200);
    }
}
