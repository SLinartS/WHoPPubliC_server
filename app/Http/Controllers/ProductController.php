<?php

namespace App\Http\Controllers;

use App\Actions\ProductResponsePrepare;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(ProductResponsePrepare $productResponsePrepare)
    {
        $products = Product::select('id', 'article', 'title', 'author', 'year_of_publication', 'number', 'print_date',)
            ->addSelect(['category' => Category::select('title')->whereColumn('id', 'category_id')])
            ->get();

        $response = $productResponsePrepare($products);

        return response()->json($response, 200);
    }
}
