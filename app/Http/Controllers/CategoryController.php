<?php

namespace App\Http\Controllers;

use App\Actions\CategoryResponsePrepare;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(CategoryResponsePrepare $categoryResponsePrepare)
    {

        try {
            $categories = Category::select('id', 'title')->get();
            $response = $categoryResponsePrepare($categories);

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            response($th->getMessage(), 422);
        }
    }
}
