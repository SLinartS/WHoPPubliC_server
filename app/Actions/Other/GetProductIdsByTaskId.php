<?php

namespace App\Actions\Other;

use App\Models\Category;
use App\Models\Product;
use Throwable;

class GetProductIdsByTaskId
{
  public function __invoke(int $taskId): array
  {
    $productIds = Product::select('id')
      ->addSelect(['category' => Category::select('title')->whereColumn('id', 'category_id')])
      ->join('products_tasks as PT', 'id', 'PT.product_id')
      ->where('PT.task_id', $taskId)
      ->get()->pluck('id')->toArray();

    return $productIds;
  }
}
