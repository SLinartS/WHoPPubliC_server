<?php

namespace Database\Seeders;

use App\Models\Floor;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class FloorSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    Floor::factory()->count(48)
      ->state(
        new Sequence(
          ['block_id' => 1, 'number' => 1, 'capacity' => 300],
          ['block_id' => 2, 'number' => 1, 'capacity' => 300],
          ['block_id' => 3, 'number' => 1, 'capacity' => 300],
          ['block_id' => 4, 'number' => 1, 'capacity' => 300],
          ['block_id' => 5, 'number' => 1, 'capacity' => 300],
          ['block_id' => 6, 'number' => 1, 'capacity' => 300],
          ['block_id' => 7, 'number' => 1, 'capacity' => 300],
          ['block_id' => 8, 'number' => 1, 'capacity' => 300],
          ['block_id' => 9, 'number' => 1, 'capacity' => 300],
          ['block_id' => 10, 'number' => 1, 'capacity' => 300],
          ['block_id' => 11, 'number' => 1, 'capacity' => 300],
          ['block_id' => 12, 'number' => 1, 'capacity' => 300],
          ['block_id' => 1, 'number' => 2, 'capacity' => 300],
          ['block_id' => 2, 'number' => 2, 'capacity' => 300],
          ['block_id' => 3, 'number' => 2, 'capacity' => 300],
          ['block_id' => 4, 'number' => 2, 'capacity' => 300],
          ['block_id' => 5, 'number' => 2, 'capacity' => 300],
          ['block_id' => 6, 'number' => 2, 'capacity' => 300],
          ['block_id' => 7, 'number' => 2, 'capacity' => 300],
          ['block_id' => 8, 'number' => 2, 'capacity' => 300],
          ['block_id' => 9, 'number' => 2, 'capacity' => 300],
          ['block_id' => 10, 'number' => 2, 'capacity' => 300],
          ['block_id' => 11, 'number' => 2, 'capacity' => 300],
          ['block_id' => 12, 'number' => 2, 'capacity' => 300],
          ['block_id' => 1, 'number' => 3, 'capacity' => 300],
          ['block_id' => 2, 'number' => 3, 'capacity' => 300],
          ['block_id' => 3, 'number' => 3, 'capacity' => 300],
          ['block_id' => 4, 'number' => 3, 'capacity' => 300],
          ['block_id' => 5, 'number' => 3, 'capacity' => 300],
          ['block_id' => 6, 'number' => 3, 'capacity' => 300],
          ['block_id' => 7, 'number' => 3, 'capacity' => 300],
          ['block_id' => 8, 'number' => 3, 'capacity' => 300],
          ['block_id' => 9, 'number' => 3, 'capacity' => 300],
          ['block_id' => 10, 'number' => 3, 'capacity' => 300],
          ['block_id' => 11, 'number' => 3, 'capacity' => 300],
          ['block_id' => 12, 'number' => 3, 'capacity' => 300],
          ['block_id' => 1, 'number' => 4, 'capacity' => 300],
          ['block_id' => 2, 'number' => 4, 'capacity' => 300],
          ['block_id' => 3, 'number' => 4, 'capacity' => 300],
          ['block_id' => 4, 'number' => 4, 'capacity' => 300],
          ['block_id' => 5, 'number' => 4, 'capacity' => 300],
          ['block_id' => 6, 'number' => 4, 'capacity' => 300],
          ['block_id' => 7, 'number' => 4, 'capacity' => 300],
          ['block_id' => 8, 'number' => 4, 'capacity' => 300],
          ['block_id' => 9, 'number' => 4, 'capacity' => 300],
          ['block_id' => 10, 'number' => 4, 'capacity' => 300],
          ['block_id' => 11, 'number' => 4, 'capacity' => 300],
          ['block_id' => 12, 'number' => 4, 'capacity' => 300],
        )
      )->create();
  }
}
