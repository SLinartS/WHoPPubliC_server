<?php

namespace App\Services;

use App\Actions\ResponsePrepare\Option;
use App\Models\ProductType as ModelsProductType;

class ProductType
{
  public function index()
  {
    $productTypes = ModelsProductType::select('id', 'title', 'alias')->get();

    return (new Option())($productTypes);
  }
}
