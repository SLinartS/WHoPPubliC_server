<?php

namespace App\Http\Controllers;

use App\Actions\PointResponsePrepare;
use App\Models\Point;
use Illuminate\Http\Request;

class PointController extends Controller
{
    public function index($pointType, PointResponsePrepare $pointResponsePrepare)
    {
        $points = [];
        switch ($pointType) {
            case 'acceptance':
                $points = Point::select('id', 'title', 'is_acceptance')->where('is_acceptance', 1)->get();
                break;
            case 'shipment':
                $points = Point::select('id', 'title', 'is_acceptance')->where('is_acceptance', 0)->get();
                break;
            default:
                return response('Unknown point type', 404);
        }

        $response = $pointResponsePrepare($points);

        return response()->json($response, 200);
    }
}
