<?php

namespace Database\Seeders;

use App\Models\ProductFloor;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ProductFloorSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    ProductFloor::factory()->count(36)
    ->state(
      new Sequence(
        ['product_id' => 1, 'floor_id' => 1, 'occupied_space' => 100, 'is_actual' => false],
        ['product_id' => 2, 'floor_id' => 1, 'occupied_space' => 100, 'is_actual' => false],
        ['product_id' => 3, 'floor_id' => 2, 'occupied_space' => 100, 'is_actual' => false],
        ['product_id' => 4, 'floor_id' => 3, 'occupied_space' => 100, 'is_actual' => false],
        ['product_id' => 5, 'floor_id' => 4, 'occupied_space' => 100, 'is_actual' => false],
        ['product_id' => 6, 'floor_id' => 5, 'occupied_space' => 100, 'is_actual' => false],
        ['product_id' => 7, 'floor_id' => 5, 'occupied_space' => 100, 'is_actual' => false],
        ['product_id' => 8, 'floor_id' => 6, 'occupied_space' => 100, 'is_actual' => false],
        ['product_id' => 9, 'floor_id' => 7, 'occupied_space' => 100, 'is_actual' => true],
        ['product_id' => 10, 'floor_id' => 8, 'occupied_space' => 100, 'is_actual' => true],
        ['product_id' => 11, 'floor_id' => 48, 'occupied_space' => 100, 'is_actual' => true],
        ['product_id' => 12, 'floor_id' => 11, 'occupied_space' => 100, 'is_actual' => true],
        ['product_id' => 13, 'floor_id' => 46, 'occupied_space' => 100, 'is_actual' => true],
        ['product_id' => 14, 'floor_id' => 32, 'occupied_space' => 100, 'is_actual' => true],
        ['product_id' => 15, 'floor_id' => 32, 'occupied_space' => 100, 'is_actual' => true],
        ['product_id' => 16, 'floor_id' => 5, 'occupied_space' => 100, 'is_actual' => true],
        ['product_id' => 14, 'floor_id' => 3, 'occupied_space' => 100, 'is_actual' => false],
        ['product_id' => 15, 'floor_id' => 41, 'occupied_space' => 100, 'is_actual' => false],
        ['product_id' => 16, 'floor_id' => 20, 'occupied_space' => 100, 'is_actual' => false],
        ['product_id' => 17, 'floor_id' => 17, 'occupied_space' => 100, 'is_actual' => false],
        ['product_id' => 18, 'floor_id' => 11, 'occupied_space' => 100, 'is_actual' => false],
        ['product_id' => 19, 'floor_id' => 16, 'occupied_space' => 100, 'is_actual' => false],
        ['product_id' => 20, 'floor_id' => 16, 'occupied_space' => 100, 'is_actual' => true],
        ['product_id' => 21, 'floor_id' => 20, 'occupied_space' => 100, 'is_actual' => true],
        ['product_id' => 22, 'floor_id' => 30, 'occupied_space' => 100, 'is_actual' => true],
        ['product_id' => 23, 'floor_id' => 31, 'occupied_space' => 100, 'is_actual' => true],
        ['product_id' => 24, 'floor_id' => 40, 'occupied_space' => 100, 'is_actual' => true],
        ['product_id' => 25, 'floor_id' => 41, 'occupied_space' => 100, 'is_actual' => true],
        ['product_id' => 23, 'floor_id' => 33, 'occupied_space' => 100, 'is_actual' => false],
        ['product_id' => 24, 'floor_id' => 46, 'occupied_space' => 100, 'is_actual' => false],
        ['product_id' => 25, 'floor_id' => 11, 'occupied_space' => 100, 'is_actual' => false],
        ['product_id' => 31, 'floor_id' => 15, 'occupied_space' => 100, 'is_actual' => true],
        ['product_id' => 32, 'floor_id' => 15, 'occupied_space' => 100, 'is_actual' => true],
        ['product_id' => 33, 'floor_id' => 14, 'occupied_space' => 100, 'is_actual' => true],
        ['product_id' => 34, 'floor_id' => 13, 'occupied_space' => 100, 'is_actual' => true],
        ['product_id' => 35, 'floor_id' => 12, 'occupied_space' => 100, 'is_actual' => true],
      )
    )->create();
  }
}
