<?php

namespace Database\Seeders;

use App\Models\ProductTask;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ProductTaskSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    ProductTask::factory()->count(25)
    ->state(
      new Sequence(
        ['product_id' => 1, 'task_id' => 1],
        ['product_id' => 2, 'task_id' => 1],
        ['product_id' => 3, 'task_id' => 1],
        ['product_id' => 4, 'task_id' => 2],
        ['product_id' => 5, 'task_id' => 2],
        ['product_id' => 6, 'task_id' => 2],
        ['product_id' => 7, 'task_id' => 3],
        ['product_id' => 8, 'task_id' => 3],
        ['product_id' => 9, 'task_id' => 4],
        ['product_id' => 10, 'task_id' => 4],
        ['product_id' => 11, 'task_id' => 5],
        ['product_id' => 12, 'task_id' => 5],
        ['product_id' => 13, 'task_id' => 6],
        ['product_id' => 14, 'task_id' => 7],
        ['product_id' => 15, 'task_id' => 8],
        ['product_id' => 16, 'task_id' => 9],
        ['product_id' => 17, 'task_id' => 10],
        ['product_id' => 18, 'task_id' => 11],
        ['product_id' => 19, 'task_id' => 12],
        ['product_id' => 20, 'task_id' => 13],
        ['product_id' => 21, 'task_id' => 14],
        ['product_id' => 22, 'task_id' => 15],
        ['product_id' => 23, 'task_id' => 16],
        ['product_id' => 24, 'task_id' => 17],
        ['product_id' => 25, 'task_id' => 18],
      )
    )->create();
  }
}
