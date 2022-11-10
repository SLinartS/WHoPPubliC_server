<?php

namespace App\Http\Controllers;

use App\Actions\MapResponsePrepare;
use App\Http\Controllers\Utils\ProductFloorUtils;
use App\Http\Controllers\Utils\ProductUtils;
use App\Models\Block;
use App\Models\Floor;
use App\Models\Section;
use App\Models\Zone;
use Exception;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index(
        MapResponsePrepare $mapResponsePrepare,
        ProductFloorUtils $productFloorUtils,
        ProductUtils $productUtils
    ) {
        try {
            $zones = Zone::select('id', 'number', 'letter')->get();
            $sections = Section::select('id', 'number', 'zone_id')->get();
            $blocks = Block::select('id', 'number', 'section_id')->get();
            $floors = Floor::select('id', 'number', 'block_id', 'capacity')->get();


            $productsFloors = $productFloorUtils->index();

            $productIds = [];
            foreach ($productsFloors as $productFloor) {
                array_push($productIds, $productFloor->product_id);
            };

            $products = $productUtils->getProductsNumbersByIds($productIds);

            $response = $mapResponsePrepare(
                $zones,
                $sections,
                $blocks,
                $floors,
                $productsFloors,
                $products
            );

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th], 500);
        }
    }
}
