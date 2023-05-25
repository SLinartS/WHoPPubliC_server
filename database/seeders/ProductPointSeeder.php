<?php

namespace Database\Seeders;

use App\Models\ProductPoint;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ProductPointSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    ProductPoint::factory()->count(24)
      ->state(
        new Sequence(
          ['product_id' => 1, 'point_id' => 1],
          ['product_id' => 2, 'point_id' => 1],
          ['product_id' => 3, 'point_id' => 2],
          ['product_id' => 4, 'point_id' => 2],
          ['product_id' => 5, 'point_id' => 3],
          ['product_id' => 6, 'point_id' => 4],
          ['product_id' => 7, 'point_id' => 5],
          ['product_id' => 8, 'point_id' => 5],
          ['product_id' => 17, 'point_id' => 1],
          ['product_id' => 18, 'point_id' => 2],
          ['product_id' => 19, 'point_id' => 3],
          ['product_id' => 26, 'point_id' => 1],
          ['product_id' => 27, 'point_id' => 4],
          ['product_id' => 28, 'point_id' => 5],
          ['product_id' => 29, 'point_id' => 3],
          ['product_id' => 30, 'point_id' => 2],
          ['product_id' => 9, 'point_id' => 6],
          ['product_id' => 10, 'point_id' => 7],
          ['product_id' => 11, 'point_id' => 8],
          ['product_id' => 12, 'point_id' => 9],
          ['product_id' => 13, 'point_id' => 10],
          ['product_id' => 20, 'point_id' => 6],
          ['product_id' => 21, 'point_id' => 7],
          ['product_id' => 22, 'point_id' => 8],
        )
      )->create();
  }
}
