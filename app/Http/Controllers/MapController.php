<?php

namespace App\Http\Controllers;

use App\Actions\MapResponsePrepare;
use App\Models\Block;
use App\Models\Floor;
use App\Models\Section;
use App\Models\Zone;

class MapController extends Controller
{
    public function index(
        MapResponsePrepare $mapResponsePrepare,
    ) {
        try {
            $zones = Zone::select('id', 'number', 'letter')->get();
            $sections = Section::select('id', 'number', 'zone_id')->get();
            $blocks = Block::select('id', 'number', 'section_id')->get();
            $floors = Floor::select('id', 'number', 'block_id', 'capacity')->get();

            $response = $mapResponsePrepare(
                $zones,
                $sections,
                $blocks,
                $floors
            );

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th], 500);
        }
    }
}
