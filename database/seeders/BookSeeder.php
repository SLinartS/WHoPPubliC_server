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
          ['product_id' => 1, 'author' => 'Галкин Матвей Кириллович', 'year_of_publication' => '2003', 'year_of_printing' => '1995', 'printing_house' => 'Московский Дом Книги', 'publishing_house' => 'Книжный Лабиринт'],
          ['product_id' => 2, 'author' => 'Белоусова София Львовна', 'year_of_publication' => '2001', 'year_of_printing' => '2011', 'printing_house' => 'Техническая книга', 'publishing_house' => 'Деловая литература'],
          ['product_id' => 3, 'author' => 'Масленников Кирилл Николаевич', 'year_of_publication' => '1964', 'year_of_printing' => '2005', 'printing_house' => 'Аристотель', 'publishing_house' => 'Автограф'],
          ['product_id' => 4, 'author' => 'Анисимов Андрей Макарович', 'year_of_publication' => '2001', 'year_of_printing' => '2001', 'printing_house' => 'Порядок слов', 'publishing_house' => 'Либрис'],
          ['product_id' => 5, 'author' => 'Дмитриев Максим Всеволодович', 'year_of_publication' => '2005', 'year_of_printing' => '2009', 'printing_house' => 'Переплётные птицы', 'publishing_house' => 'Моя книга'],
          ['product_id' => 6, 'author' => 'Гончарова Ева Артёмовна', 'year_of_publication' => '1976', 'year_of_printing' => '2011', 'printing_house' => 'Папирус', 'publishing_house' => 'Сова'],
          ['product_id' => 7, 'author' => 'Маркова Елизавета Степановна', 'year_of_publication' => '1998', 'year_of_printing' => '2008', 'printing_house' => 'Почитайка', 'publishing_house' => 'Живое слово'],
          ['product_id' => 8, 'author' => 'Федосеев Владислав Павлович', 'year_of_publication' => '1998', 'year_of_printing' => '2016', 'printing_house' => 'Эврика', 'publishing_house' => 'Книжица'],
          ['product_id' => 9, 'author' => 'Алексеева Наталья Андреевна', 'year_of_publication' => '2015', 'year_of_printing' => '2019', 'printing_house' => 'Книжный корешок', 'publishing_house' => 'Автограф'],
          ['product_id' => 10, 'author' => 'Тихонова Ксения Владимировна', 'year_of_publication' => '1955', 'year_of_printing' => '2017', 'printing_house' => 'Планета', 'publishing_house' => 'Деловая литература'],
          ['product_id' => 11, 'author' => 'Коновалова Ксения Ивановна', 'year_of_publication' => '1976', 'year_of_printing' => '2006', 'printing_house' => 'Бакалавр', 'publishing_house' => 'Любимая книга'],
          ['product_id' => 12, 'author' => 'Козырев Захар Романович', 'year_of_publication' => '1995', 'year_of_printing' => '2007', 'printing_house' => 'Книжный Барс', 'publishing_house' => 'Либрис'],
          ['product_id' => 13, 'author' => 'Павлов Максим Матвеевич', 'year_of_publication' => '1999', 'year_of_printing' => '2015', 'printing_house' => 'Эрудит', 'publishing_house' => 'Любимая книга'],
          ['product_id' => 14, 'author' => 'Алешин Ярослав Маркович', 'year_of_publication' => '1958', 'year_of_printing' => '2012', 'printing_house' => 'Знайка', 'publishing_house' => '100000 книг'],
          ['product_id' => 15, 'author' => 'Сорокина Анастасия Григорьевна', 'year_of_publication' => '1995', 'year_of_printing' => '2010', 'printing_house' => 'Циолковский', 'publishing_house' => 'Все свободны'],
          ['product_id' => 16, 'author' => 'Столяров Матвей Захарович', 'year_of_publication' => '2001', 'year_of_printing' => '2006', 'printing_house' => 'Букервиль', 'publishing_house' => 'Мысль'],
          ['product_id' => 17, 'author' => 'Новикова Ольга Ильинична', 'year_of_publication' => '1995', 'year_of_printing' => '2009', 'printing_house' => 'Книгоград', 'publishing_house' => 'Буквоед'],
          ['product_id' => 18, 'author' => 'Гордеев Богдан Владимирович', 'year_of_publication' => '2005', 'year_of_printing' => '2011', 'printing_house' => 'Лингва', 'publishing_house' => 'Полезная книга'],
          ['product_id' => 19, 'author' => 'Ершова Мария Павловна', 'year_of_publication' => '1987', 'year_of_printing' => '2008', 'printing_house' => 'Читайна', 'publishing_house' => 'Книжная нора'],
          ['product_id' => 20, 'author' => 'Маркин Елисей Максимович', 'year_of_publication' => '1964', 'year_of_printing' => '2008', 'printing_house' => '', 'publishing_house' => 'Кирилл и Мефодий'],
        )
      )->create();
  }
}
