<?php

namespace App\Services;

use App\Actions\ResponsePrepare\Option;
use App\Models\Category as ModelsCategory;

class Category
{
  public function index()
  {
    $categories = ModelsCategory::select('id', 'title', 'alias')->get();

    return (new Option())($categories);
  }
}
