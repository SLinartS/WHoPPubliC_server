<?php

namespace App\Http\Controllers;

use App\Actions\PointResponsePrepare;
use App\Models\Point;
use Illuminate\Http\Request;
use Throwable;

class PointController extends Controller
{
    public function index(PointResponsePrepare $pointResponsePrepare)
    {
        try {
            $points = Point::select('id', 'title', 'is_acceptance')->get();
            $response = $pointResponsePrepare($points);

            return response()->json($response, 200);
        } catch (Throwable $th) {
            return response($th, 500);
        }
    }
}
