<?php

namespace Database\Seeders;

use App\Models\TypeOfPoint;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class TypeOfPointSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    TypeOfPoint::factory()->count(2)
    ->state(
      (new Sequence(
        ['type' => 'acceptance'],
        ['type' => 'shipment']
      ))
    )->create();
  }
}
