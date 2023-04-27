<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Task::factory()->count(18)
    ->state(
      (new Sequence(
        // 06
        [
            'time_start' => '2021-06-17 10:00:00',
            'time_end' => '2021-06-18 08:00:00',
            'time_completion' => '2021-06-19 09:00:00',
            'type_id' => 1
        ],
        [
            'time_start' => '2021-06-17 10:00:00',
            'time_end' => '2021-06-19 17:00:00',
            'time_completion' => '2021-06-19 17:00:00',
            'type_id' => 1
        ],
        [
            'time_start' => '2021-06-17 10:00:00',
            'time_end' => '2021-06-18 8:00:00',
            'time_completion' => '2021-06-18 09:00:00',
            'type_id' => 1
        ],
        [
            'time_start' => '2021-06-17 10:00:00',
            'time_end' => '2021-06-18 12:00:00',
            'time_completion' => '2021-06-19 10:00:00',
            'type_id' => 2
        ],
        [
            'time_start' => '2021-06-17 10:00:00',
            'time_end' => '2021-06-18 14:00:00',
            'time_completion' => '2021-06-18 13:00:00',
            'type_id' => 2
        ],
        [
            'time_start' => '2021-06-17 10:00:00',
            'time_end' => '2021-06-19 20:00:00',
            'time_completion' => '2021-06-20 08:00:00',
            'type_id' => 2
        ],
        [
            'time_start' => '2021-06-17 10:00:00',
            'time_end' => '2021-06-18 18:00:00',
            'time_completion' => '2021-06-19 09:00:00',
            'type_id' => 3
        ],
        [
            'time_start' => '2021-06-17 10:00:00',
            'time_end' => '2021-06-18 15:00:00',
            'time_completion' => '2021-06-18 13:00:00',
            'type_id' => 3
        ],
        [
            'time_start' => '2021-06-17 10:00:00',
            'time_end' => '2021-06-18 08:00:00',
            'time_completion' => '2021-06-19 09:00:00',
            'type_id' => 3
        ],
        // 07
        [
            'time_start' => '2021-07-17 10:00:00',
            'time_end' => '2021-07-18 14:00:00',
            'time_completion' => '2021-07-19 9:00:00',
            'type_id' => 1
        ],
        [
            'time_start' => '2021-07-17 10:00:00',
            'time_end' => '2021-07-19 17:00:00',
            'time_completion' => '2021-07-19 17:00:00',
            'type_id' => 1
        ],
        [
            'time_start' => '2021-07-17 10:00:00',
            'time_end' => '2021-07-18 8:00:00',
            'time_completion' => '2021-07-18 09:00:00',
            'type_id' => 1
        ],
        [
            'time_start' => '2021-07-17 10:00:00',
            'time_end' => '2021-07-18 12:00:00',
            'time_completion' => '2021-07-19 10:00:00',
            'type_id' => 2
        ],
        [
            'time_start' => '2021-07-17 10:00:00',
            'time_end' => '2021-07-18 12:00:00',
            'time_completion' => '2021-07-18 18:00:00',
            'type_id' => 2
        ],
        [
            'time_start' => '2021-07-17 10:00:00',
            'time_end' => '2021-07-19 22:00:00',
            'time_completion' => '2021-07-20 08:00:00',
            'type_id' => 2
        ],
        [
            'time_start' => '2021-07-17 10:00:00',
            'time_end' => '2021-07-18 18:00:00',
            'time_completion' => '2021-07-18 16:00:00',
            'type_id' => 3
        ],
        [
            'time_start' => '2021-07-17 10:00:00',
            'time_end' => '2021-07-18 15:00:00',
            'time_completion' => '2021-07-18 13:00:00',
            'type_id' => 3
        ],
        [
            'time_start' => '2021-07-17 10:00:00',
            'time_end' => '2021-07-19 15:00:00',
            'time_completion' => '2021-07-19 14:00:00',
            'type_id' => 3
        ],
      ))
    )->create();
  }
}
