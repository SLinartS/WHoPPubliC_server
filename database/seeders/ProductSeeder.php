<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Product::factory()->count(35)
      ->state(
        new Sequence(
          ['number' => 100, 'type_id' => 1],
          ['number' => 100, 'type_id' => 1],
          ['number' => 100, 'type_id' => 1],
          ['number' => 100, 'type_id' => 1],
          ['number' => 100, 'type_id' => 1],
          ['number' => 100, 'type_id' => 1],
          ['number' => 100, 'type_id' => 1],
          ['number' => 100, 'type_id' => 1],
          ['number' => 100, 'type_id' => 1],
          ['number' => 100, 'type_id' => 1],
          ['number' => 100, 'type_id' => 1],
          ['number' => 100, 'type_id' => 1],
          ['number' => 100, 'type_id' => 1],
          ['number' => 100, 'type_id' => 1],
          ['number' => 100, 'type_id' => 1],
          ['number' => 100, 'type_id' => 1],
          ['number' => 100, 'type_id' => 1],
          ['number' => 100, 'type_id' => 1],
          ['number' => 100, 'type_id' => 1],
          ['number' => 100, 'type_id' => 1], // 20
          ['number' => 100, 'type_id' => 2],
          ['number' => 100, 'type_id' => 2],
          ['number' => 100, 'type_id' => 2],
          ['number' => 100, 'type_id' => 2],
          ['number' => 100, 'type_id' => 2],
          ['number' => 100, 'type_id' => 2],
          ['number' => 100, 'type_id' => 2],
          ['number' => 100, 'type_id' => 2],
          ['number' => 100, 'type_id' => 2],
          ['number' => 100, 'type_id' => 2], // 30
          ['number' => 100, 'type_id' => 3],
          ['number' => 100, 'type_id' => 3],
          ['number' => 100, 'type_id' => 3],
          ['number' => 100, 'type_id' => 3],
          ['number' => 100, 'type_id' => 3], // 35
        )
      )->create();
  }
}
