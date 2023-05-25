<?php

namespace Database\Seeders;

use App\Models\AuthorizationHistory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class AuthorizationHistorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    AuthorizationHistory::factory()->count(12)
      ->state(
        (new Sequence(
          // 06
          ['user_id' => 1, 'time_authorization' => '2021-06-18 8:00:00'],
          ['user_id' => 1, 'time_authorization' => '2021-06-18 15:00:00'],
          ['user_id' => 3, 'time_authorization' => '2021-06-20 8:00:00'],
          ['user_id' => 4, 'time_authorization' => '2021-06-21 10:00:00'],
          ['user_id' => 4, 'time_authorization' => '2021-06-22 11:00:00'],
          ['user_id' => 5, 'time_authorization' => '2021-06-23 9:00:00'],
          // 07
          ['user_id' => 1, 'time_authorization' => '2021-07-18 10:00:00'],
          ['user_id' => 2, 'time_authorization' => '2021-07-18 15:00:00'],
          ['user_id' => 4, 'time_authorization' => '2021-07-20 8:00:00'],
          ['user_id' => 6, 'time_authorization' => '2021-07-21 7:00:00'],
          ['user_id' => 6, 'time_authorization' => '2021-07-22 11:00:00'],
          ['user_id' => 6, 'time_authorization' => '2021-07-23 8:00:00'],
        ))
      )->create();
  }
}
