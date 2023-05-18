<?php

namespace Database\Seeders;

use App\Models\TypeOfFile;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class TypeOfFileSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    TypeOfFile::factory()->count(2)
      ->state(
        (new Sequence(
          ['title' => 'performance', 'alias' => 'Отчёты о качестве работы'],
          ['title' => 'balance', 'alias' => 'Отчёты об остатках'],
        ))
      )
      ->create();
  }
}
