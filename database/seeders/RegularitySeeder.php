<?php

namespace Database\Seeders;

use App\Models\Regularity;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class RegularitySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Regularity::factory()->count(3)
    ->state(
      (new Sequence(
        ['alias' => 'Ежедневный'],
        ['alias' => 'Еженедельный'],
        ['alias' => 'Ежемесячный'],
      ))
    )->create();
  }
}
