<?php

namespace Database\Seeders;

use App\Models\Block;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class BlockSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Block::factory()->count(12)
      ->state(
        new Sequence(
          ['section_id' => 1, 'number' => 1],
          ['section_id' => 2, 'number' => 1],
          ['section_id' => 3, 'number' => 1],
          ['section_id' => 4, 'number' => 1],
          ['section_id' => 5, 'number' => 1],
          ['section_id' => 6, 'number' => 1],
          ['section_id' => 1, 'number' => 2],
          ['section_id' => 2, 'number' => 2],
          ['section_id' => 3, 'number' => 2],
          ['section_id' => 4, 'number' => 2],
          ['section_id' => 5, 'number' => 2],
          ['section_id' => 6, 'number' => 2],
        )
      )->create();
  }
}
