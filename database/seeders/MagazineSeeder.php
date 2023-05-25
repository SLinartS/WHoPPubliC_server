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
          ['product_id' => 21, 'date_of_printing' => '2017-02-24', 'printing_house' => 'Московский Дом Книги', 'publishing_house' => 'Книжный Лабиринт'],
          ['product_id' => 22, 'date_of_printing' => '2019-02-26', 'printing_house' => 'Техническая книга', 'publishing_house' => 'Деловая литература'],
          ['product_id' => 23, 'date_of_printing' => '2020-09-22', 'printing_house' => 'Аристотель', 'publishing_house' => 'Автограф'],
          ['product_id' => 24, 'date_of_printing' => '2017-10-18', 'printing_house' => 'Порядок слов', 'publishing_house' => 'Либрис'],
          ['product_id' => 25, 'date_of_printing' => '2018-11-12', 'printing_house' => 'Переплётные птицы', 'publishing_house' => 'Моя книга'],
          ['product_id' => 26, 'date_of_printing' => '2021-06-27', 'printing_house' => 'Папирус', 'publishing_house' => 'Сова'],
          ['product_id' => 27, 'date_of_printing' => '2018-02-19', 'printing_house' => 'Почитайка', 'publishing_house' => 'Живое слово'],
          ['product_id' => 28, 'date_of_printing' => '2019-07-09', 'printing_house' => 'Эврика', 'publishing_house' => 'Книжица'],
          ['product_id' => 29, 'date_of_printing' => '2017-03-24', 'printing_house' => 'Книжный корешок', 'publishing_house' => 'Автограф'],
          ['product_id' => 30, 'date_of_printing' => '2022-08-15', 'printing_house' => 'Планета', 'publishing_house' => 'Деловая литература'],
        )
      )->create();
  }
}
