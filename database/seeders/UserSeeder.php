<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    User::factory()->count(10)
      ->state(
        (new Sequence(
          ['login' => 'login'],
          ['login' => 'login2'],
          ['login' => 'login3'],
          ['login' => 'login4'],
          ['login' => 'login5'],
          ['login' => 'login6'],
          ['login' => 'login7'],
          ['login' => 'login8'],
          ['login' => 'login9'],
          ['login' => 'login10'],
        ))
      )
      ->create();
  }
}
