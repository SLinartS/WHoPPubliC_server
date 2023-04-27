<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Book::factory()->count(20)
    ->state(
      new Sequence(
        ['product_id' => 1],
        ['product_id' => 2],
        ['product_id' => 3],
        ['product_id' => 4],
        ['product_id' => 5],
        ['product_id' => 6],
        ['product_id' => 7],
        ['product_id' => 8],
        ['product_id' => 9],
        ['product_id' => 10],
        ['product_id' => 11],
        ['product_id' => 12],
        ['product_id' => 13],
        ['product_id' => 14],
        ['product_id' => 15],
        ['product_id' => 16],
        ['product_id' => 17],
        ['product_id' => 18],
        ['product_id' => 19],
        ['product_id' => 20],
      )
    )->create();
  }
}
