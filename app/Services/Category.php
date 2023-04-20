<?php

namespace App\Services;

use App\Actions\ResponsePrepare\Category as ResponsePrepareCategory;
use App\Models\Category as ModelsCategory;
use App\Models\ProductTypes;

class Category
{
  public function index()
  {
    $categories = ModelsCategory::select('id', 'title', 'product_type_id')
    ->addSelect(['productType' => ProductTypes::select('title')->whereColumn('id', 'product_type_id')])
    ->get();

    return (new ResponsePrepareCategory())($categories);
  }
}
