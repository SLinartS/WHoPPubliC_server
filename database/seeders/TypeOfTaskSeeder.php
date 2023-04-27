<?php

namespace Database\Seeders;

use App\Models\TypeOfTask;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class TypeOfTaskSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    TypeOfTask::factory()->count(3)
    ->state(
      (new Sequence(
        ['type' => 'acceptance'],
        ['type' => 'shipment'],
        ['type' => 'intro'],
      ))
    )->create();
  }
}
