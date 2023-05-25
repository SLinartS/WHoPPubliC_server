<?php

namespace Database\Seeders;

use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Zone::factory()->count(3)
      ->state(
        new Sequence(
          ['number' => 1, 'letter' => 'A'],
          ['number' => 2, 'letter' => 'B'],
          ['number' => 3, 'letter' => 'C'],
        )
      )
      ->create();
  }
}
