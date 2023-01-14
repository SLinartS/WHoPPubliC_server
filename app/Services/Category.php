<?php

namespace App\Services;

use App\Actions\ResponsePrepare\Category as ResponsePrepareCategory;
use App\Models\Category as ModelsCategory;

class Category
{
  public function index()
  {
    $categories = ModelsCategory::select('id', 'title')->get();

    return (new ResponsePrepareCategory())($categories);
  }
}
