<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    ProductType::factory()->count(3)
    ->state(
      (new Sequence(
        ['title' => 'book', 'alias' => 'Книга'],
        ['title' => 'magazine', 'alias' => 'Журнал'],
        ['title' => 'other', 'alias' => 'Другое'],
      ))
    )->create();
  }
}
