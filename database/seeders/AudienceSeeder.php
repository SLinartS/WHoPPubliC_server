<?php

namespace Database\Seeders;

use App\Models\Audience;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class AudienceSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Audience::factory()->count(3)
    ->state(
      (new Sequence(
        ['title' => 'Дети'],
        ['title' => 'Подростки'],
        ['title' => 'Взрослые'],
      ))
    )->create();
  }
}
