<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Section::factory()->count(6)
    ->state(
      new Sequence(
        ['zone_id' => 1, 'number' => 1],
        ['zone_id' => 2, 'number' => 1],
        ['zone_id' => 3, 'number' => 1],
        ['zone_id' => 1, 'number' => 2],
        ['zone_id' => 2, 'number' => 2],
        ['zone_id' => 3, 'number' => 2],
      )
    )->create();
  }
}
