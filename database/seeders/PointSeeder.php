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
          ['type_id' => 1, 'title' => 'A1'],
          ['type_id' => 1, 'title' => 'A2'],
          ['type_id' => 1, 'title' => 'A3'],
          ['type_id' => 1, 'title' => 'A4'],
          ['type_id' => 1, 'title' => 'A5'],
          ['type_id' => 2, 'title' => 'B1'],
          ['type_id' => 2, 'title' => 'B2'],
          ['type_id' => 2, 'title' => 'B3'],
          ['type_id' => 2, 'title' => 'B4'],
          ['type_id' => 2, 'title' => 'B5'],
        ))
      )->create();
  }
}
