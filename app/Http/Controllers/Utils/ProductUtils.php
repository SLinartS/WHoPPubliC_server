<?php

namespace App\Http\Controllers\Utils;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductUtils extends Controller
{

    public function getProductsNumbersByIds(array $productIds)
    {
        try {
            $products = Product::select('id', 'number')
                ->whereIn('id', $productIds)
                ->get();

            return $products;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
