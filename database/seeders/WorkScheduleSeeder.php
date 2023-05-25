<?php

namespace Database\Seeders;

use App\Models\WorkSchedule;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class WorkScheduleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    for ($i = 1; $i <= 10; $i++) {
      WorkSchedule::factory()->count(7)
        ->state(
          (new Sequence(
            ['user_id' => $i, 'day_of_week' => 0],
            ['user_id' => $i, 'day_of_week' => 1],
            ['user_id' => $i, 'day_of_week' => 2],
            ['user_id' => $i, 'day_of_week' => 3],
            ['user_id' => $i, 'day_of_week' => 4],
            ['user_id' => $i, 'day_of_week' => 5],
            ['user_id' => $i, 'day_of_week' => 6],
          ))
        )->create();
    }
  }
}
