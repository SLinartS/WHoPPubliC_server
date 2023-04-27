<?php

namespace Database\Seeders;

use App\Models\Magazine;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class MagazineSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Magazine::factory()->count(10)
    ->state(
      new Sequence(
        ['product_id' => 21],
        ['product_id' => 22],
        ['product_id' => 23],
        ['product_id' => 24],
        ['product_id' => 25],
        ['product_id' => 26],
        ['product_id' => 27],
        ['product_id' => 28],
        ['product_id' => 29],
        ['product_id' => 30],
      )
    )->create();
  }
}
