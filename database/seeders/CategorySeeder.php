<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Category::factory()->count(5)
      ->state(
        (new Sequence(
          ['alias' => 'Учебная литература для ВУЗов'],
          ['alias' => 'Учебная литература для СУЗов'],
          ['alias' => 'Учебная литература (школы)'],
          ['alias' => 'Художественная литература'],
          ['alias' => 'Художественная литература (детская)'],
        ))
      )->create();
  }
}
