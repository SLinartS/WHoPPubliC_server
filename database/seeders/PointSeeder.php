<?php

namespace Database\Seeders;

use App\Models\Point;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class PointSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Point::factory()->count(10)
    ->state(
      (new Sequence(
        ['type_id' => 1],
        ['type_id' => 1],
        ['type_id' => 1],
        ['type_id' => 1],
        ['type_id' => 1],
        ['type_id' => 2],
        ['type_id' => 2],
        ['type_id' => 2],
        ['type_id' => 2],
        ['type_id' => 2],
      ))
    )->create();
  }
}
