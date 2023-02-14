<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AuthorizationHistory;
use App\Models\Block;
use App\Models\Category;
use App\Models\Floor;
use App\Models\Point;
use App\Models\Product;
use App\Models\ProductFloor;
use App\Models\ProductPoint;
use App\Models\ProductTask;
use App\Models\Role;
use App\Models\Section;
use App\Models\Task;
use App\Models\TaskFloor;
use App\Models\TypeOfPoint;
use App\Models\TypeOfTask;
use App\Models\User;
use App\Models\WorkSchedule;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    Role::factory()->count(3)
        ->state(
          (new Sequence(
            ['title' => 'admin', 'alias' => 'Администратор'],
            ['title' => 'operator', 'alias' => 'Оператор склада'],
            ['title' => 'worker', 'alias' => 'Работник склада'],
          ))
        )
        ->create();
    User::factory()->count(10)
        ->state(
          (new Sequence(
            ['login' => 'login'],
            ['login' => 'login2'],
          ))
        )
        ->create();

    for ($i = 1; $i <= 10; $i++) {
      WorkSchedule::factory()->count(7)
          ->state(
            (new Sequence(
              ['user_id' => $i, 'day_of_week' => 0],
              ['user_id' => $i, 'day_of_week' => 1],
              ['user_id' => $i, 'day_of_week' => 2],
              ['user_id' => $i, 'day_of_week' => 3],
              ['user_id' => $i, 'day_of_week' => 4],
              ['user_id' => $i, 'day_of_week' => 5],
              ['user_id' => $i, 'day_of_week' => 6],
            ))
          )->create();
    }

    AuthorizationHistory::factory()->count(12)
        ->state(
          (new Sequence(
            // 06
            ['user_id' => 1, 'time_authorization' => '2021-06-18 8:00:00'],
            ['user_id' => 1, 'time_authorization' => '2021-06-18 15:00:00'],
            ['user_id' => 3, 'time_authorization' => '2021-06-20 8:00:00'],
            ['user_id' => 4, 'time_authorization' => '2021-06-21 10:00:00'],
            ['user_id' => 4, 'time_authorization' => '2021-06-22 11:00:00'],
            ['user_id' => 5, 'time_authorization' => '2021-06-23 9:00:00'],
            // 07
            ['user_id' => 1, 'time_authorization' => '2021-07-18 10:00:00'],
            ['user_id' => 2, 'time_authorization' => '2021-07-18 15:00:00'],
            ['user_id' => 4, 'time_authorization' => '2021-07-20 8:00:00'],
            ['user_id' => 6, 'time_authorization' => '2021-07-21 7:00:00'],
            ['user_id' => 6, 'time_authorization' => '2021-07-22 11:00:00'],
            ['user_id' => 6, 'time_authorization' => '2021-07-23 8:00:00'],
          ))
        )->create();

    TypeOfTask::factory()->count(3)
        ->state(
          (new Sequence(
            ['type' => 'acceptance'],
            ['type' => 'shipment'],
            ['type' => 'intro'],
          ))
        )->create();

    TypeOfPoint::factory()->count(2)
        ->state(
          (new Sequence(
            ['type' => 'acceptance'],
            ['type' => 'shipment']
          ))
        )->create();

    Point::factory()->count(10)
        ->state(
          (new Sequence(
            ['type_id' => 1],
            ['type_id' => 1],
            ['type_id' => 1],
            ['type_id' => 1],
            ['type_id' => 1],
            ['type_id' => 2],
            ['type_id' => 2],
            ['type_id' => 2],
            ['type_id' => 2],
            ['type_id' => 2],
          ))
        )->create();

    Task::factory()->count(18)
        ->state(
          (new Sequence(
            // 06
            [
                'time_start' => '2021-06-17 10:00:00',
                'time_end' => '2021-06-18 08:00:00',
                'time_completion' => '2021-06-19 09:00:00',
                'type_id' => 1
            ],
            [
                'time_start' => '2021-06-17 10:00:00',
                'time_end' => '2021-06-19 17:00:00',
                'time_completion' => '2021-06-19 17:00:00',
                'type_id' => 1
            ],
            [
                'time_start' => '2021-06-17 10:00:00',
                'time_end' => '2021-06-18 8:00:00',
                'time_completion' => '2021-06-18 09:00:00',
                'type_id' => 1
            ],
            [
                'time_start' => '2021-06-17 10:00:00',
                'time_end' => '2021-06-18 12:00:00',
                'time_completion' => '2021-06-19 10:00:00',
                'type_id' => 2
            ],
            [
                'time_start' => '2021-06-17 10:00:00',
                'time_end' => '2021-06-18 14:00:00',
                'time_completion' => '2021-06-18 13:00:00',
                'type_id' => 2
            ],
            [
                'time_start' => '2021-06-17 10:00:00',
                'time_end' => '2021-06-19 20:00:00',
                'time_completion' => '2021-06-20 08:00:00',
                'type_id' => 2
            ],
            [
                'time_start' => '2021-06-17 10:00:00',
                'time_end' => '2021-06-18 18:00:00',
                'time_completion' => '2021-06-19 09:00:00',
                'type_id' => 3
            ],
            [
                'time_start' => '2021-06-17 10:00:00',
                'time_end' => '2021-06-18 15:00:00',
                'time_completion' => '2021-06-18 13:00:00',
                'type_id' => 3
            ],
            [
                'time_start' => '2021-06-17 10:00:00',
                'time_end' => '2021-06-18 08:00:00',
                'time_completion' => '2021-06-19 09:00:00',
                'type_id' => 3
            ],
            // 07
            [
                'time_start' => '2021-07-17 10:00:00',
                'time_end' => '2021-07-18 14:00:00',
                'time_completion' => '2021-07-19 9:00:00',
                'type_id' => 1
            ],
            [
                'time_start' => '2021-07-17 10:00:00',
                'time_end' => '2021-07-19 17:00:00',
                'time_completion' => '2021-07-19 17:00:00',
                'type_id' => 1
            ],
            [
                'time_start' => '2021-07-17 10:00:00',
                'time_end' => '2021-07-18 8:00:00',
                'time_completion' => '2021-07-18 09:00:00',
                'type_id' => 1
            ],
            [
                'time_start' => '2021-07-17 10:00:00',
                'time_end' => '2021-07-18 12:00:00',
                'time_completion' => '2021-07-19 10:00:00',
                'type_id' => 2
            ],
            [
                'time_start' => '2021-07-17 10:00:00',
                'time_end' => '2021-07-18 12:00:00',
                'time_completion' => '2021-07-18 18:00:00',
                'type_id' => 2
            ],
            [
                'time_start' => '2021-07-17 10:00:00',
                'time_end' => '2021-07-19 22:00:00',
                'time_completion' => '2021-07-20 08:00:00',
                'type_id' => 2
            ],
            [
                'time_start' => '2021-07-17 10:00:00',
                'time_end' => '2021-07-18 18:00:00',
                'time_completion' => '2021-07-18 16:00:00',
                'type_id' => 3
            ],
            [
                'time_start' => '2021-07-17 10:00:00',
                'time_end' => '2021-07-18 15:00:00',
                'time_completion' => '2021-07-18 13:00:00',
                'type_id' => 3
            ],
            [
                'time_start' => '2021-07-17 10:00:00',
                'time_end' => '2021-07-19 15:00:00',
                'time_completion' => '2021-07-19 14:00:00',
                'type_id' => 3
            ],
          ))
        )->create();

    Category::factory()->count(5)
        ->state(
          (new Sequence(
            ['title' => 'Учебная литература для ВУЗов'],
            ['title' => 'Учебная литература для СУЗов'],
            ['title' => 'Учебная литература (школы)'],
            ['title' => 'Художественная литература'],
            ['title' => 'Художественная литература (детская)'],
          ))
        )->create();

    Product::factory()->count(35)
        ->state(
          new Sequence(
            ['number' => 100],
          )
        )->create();

    ProductTask::factory()->count(25)
        ->state(
          new Sequence(
            ['product_id' => 1, 'task_id' => 1],
            ['product_id' => 2, 'task_id' => 1],
            ['product_id' => 3, 'task_id' => 1],
            ['product_id' => 4, 'task_id' => 2],
            ['product_id' => 5, 'task_id' => 2],
            ['product_id' => 6, 'task_id' => 2],
            ['product_id' => 7, 'task_id' => 3],
            ['product_id' => 8, 'task_id' => 3],
            ['product_id' => 9, 'task_id' => 4],
            ['product_id' => 10, 'task_id' => 4],
            ['product_id' => 11, 'task_id' => 5],
            ['product_id' => 12, 'task_id' => 5],
            ['product_id' => 13, 'task_id' => 6],
            ['product_id' => 14, 'task_id' => 7],
            ['product_id' => 15, 'task_id' => 8],
            ['product_id' => 16, 'task_id' => 9],
            ['product_id' => 17, 'task_id' => 10],
            ['product_id' => 18, 'task_id' => 11],
            ['product_id' => 19, 'task_id' => 12],
            ['product_id' => 20, 'task_id' => 13],
            ['product_id' => 21, 'task_id' => 14],
            ['product_id' => 22, 'task_id' => 15],
            ['product_id' => 23, 'task_id' => 16],
            ['product_id' => 24, 'task_id' => 17],
            ['product_id' => 25, 'task_id' => 18],
          )
        )->create();

    Zone::factory()->count(3)
        ->state(
          new Sequence(
            ['number' => 1, 'letter' => 'A'],
            ['number' => 2, 'letter' => 'B'],
            ['number' => 3, 'letter' => 'C'],
          )
        )
        ->create();
    Section::factory()->count(6)
        ->state(
          new Sequence(
            ['zone_id' => 1, 'number' => 1],
            ['zone_id' => 2, 'number' => 1],
            ['zone_id' => 3, 'number' => 1],
            ['zone_id' => 1, 'number' => 2],
            ['zone_id' => 2, 'number' => 2],
            ['zone_id' => 3, 'number' => 2],
          )
        )->create();

    Block::factory()->count(12)
        ->state(
          new Sequence(
            ['section_id' => 1, 'number' => 1],
            ['section_id' => 2, 'number' => 1],
            ['section_id' => 3, 'number' => 1],
            ['section_id' => 4, 'number' => 1],
            ['section_id' => 5, 'number' => 1],
            ['section_id' => 6, 'number' => 1],
            ['section_id' => 1, 'number' => 2],
            ['section_id' => 2, 'number' => 2],
            ['section_id' => 3, 'number' => 2],
            ['section_id' => 4, 'number' => 2],
            ['section_id' => 5, 'number' => 2],
            ['section_id' => 6, 'number' => 2],
          )
        )->create();
    Floor::factory()->count(48)
        ->state(
          new Sequence(
            ['block_id' => 1, 'number' => 1, 'capacity' => 300],
            ['block_id' => 2, 'number' => 1, 'capacity' => 300],
            ['block_id' => 3, 'number' => 1, 'capacity' => 300],
            ['block_id' => 4, 'number' => 1, 'capacity' => 300],
            ['block_id' => 5, 'number' => 1, 'capacity' => 300],
            ['block_id' => 6, 'number' => 1, 'capacity' => 300],
            ['block_id' => 7, 'number' => 1, 'capacity' => 300],
            ['block_id' => 8, 'number' => 1, 'capacity' => 300],
            ['block_id' => 9, 'number' => 1, 'capacity' => 300],
            ['block_id' => 10, 'number' => 1, 'capacity' => 300],
            ['block_id' => 11, 'number' => 1, 'capacity' => 300],
            ['block_id' => 12, 'number' => 1, 'capacity' => 300],
            ['block_id' => 1, 'number' => 2, 'capacity' => 300],
            ['block_id' => 2, 'number' => 2, 'capacity' => 300],
            ['block_id' => 3, 'number' => 2, 'capacity' => 300],
            ['block_id' => 4, 'number' => 2, 'capacity' => 300],
            ['block_id' => 5, 'number' => 2, 'capacity' => 300],
            ['block_id' => 6, 'number' => 2, 'capacity' => 300],
            ['block_id' => 7, 'number' => 2, 'capacity' => 300],
            ['block_id' => 8, 'number' => 2, 'capacity' => 300],
            ['block_id' => 9, 'number' => 2, 'capacity' => 300],
            ['block_id' => 10, 'number' => 2, 'capacity' => 300],
            ['block_id' => 11, 'number' => 2, 'capacity' => 300],
            ['block_id' => 12, 'number' => 2, 'capacity' => 300],
            ['block_id' => 1, 'number' => 3, 'capacity' => 300],
            ['block_id' => 2, 'number' => 3, 'capacity' => 300],
            ['block_id' => 3, 'number' => 3, 'capacity' => 300],
            ['block_id' => 4, 'number' => 3, 'capacity' => 300],
            ['block_id' => 5, 'number' => 3, 'capacity' => 300],
            ['block_id' => 6, 'number' => 3, 'capacity' => 300],
            ['block_id' => 7, 'number' => 3, 'capacity' => 300],
            ['block_id' => 8, 'number' => 3, 'capacity' => 300],
            ['block_id' => 9, 'number' => 3, 'capacity' => 300],
            ['block_id' => 10, 'number' => 3, 'capacity' => 300],
            ['block_id' => 11, 'number' => 3, 'capacity' => 300],
            ['block_id' => 12, 'number' => 3, 'capacity' => 300],
            ['block_id' => 1, 'number' => 4, 'capacity' => 300],
            ['block_id' => 2, 'number' => 4, 'capacity' => 300],
            ['block_id' => 3, 'number' => 4, 'capacity' => 300],
            ['block_id' => 4, 'number' => 4, 'capacity' => 300],
            ['block_id' => 5, 'number' => 4, 'capacity' => 300],
            ['block_id' => 6, 'number' => 4, 'capacity' => 300],
            ['block_id' => 7, 'number' => 4, 'capacity' => 300],
            ['block_id' => 8, 'number' => 4, 'capacity' => 300],
            ['block_id' => 9, 'number' => 4, 'capacity' => 300],
            ['block_id' => 10, 'number' => 4, 'capacity' => 300],
            ['block_id' => 11, 'number' => 4, 'capacity' => 300],
            ['block_id' => 12, 'number' => 4, 'capacity' => 300],
          )
        )->create();

    ProductFloor::factory()->count(36)
        ->state(
          new Sequence(
            ['product_id' => 1, 'floor_id' => 1, 'occupied_space' => 100, 'is_actual' => false],
            ['product_id' => 2, 'floor_id' => 1, 'occupied_space' => 100, 'is_actual' => false],
            ['product_id' => 3, 'floor_id' => 2, 'occupied_space' => 100, 'is_actual' => false],
            ['product_id' => 4, 'floor_id' => 3, 'occupied_space' => 100, 'is_actual' => false],
            ['product_id' => 5, 'floor_id' => 4, 'occupied_space' => 100, 'is_actual' => false],
            ['product_id' => 6, 'floor_id' => 5, 'occupied_space' => 100, 'is_actual' => false],
            ['product_id' => 7, 'floor_id' => 5, 'occupied_space' => 100, 'is_actual' => false],
            ['product_id' => 8, 'floor_id' => 6, 'occupied_space' => 100, 'is_actual' => false],
            ['product_id' => 9, 'floor_id' => 7, 'occupied_space' => 100, 'is_actual' => true],
            ['product_id' => 10, 'floor_id' => 8, 'occupied_space' => 100, 'is_actual' => true],
            ['product_id' => 11, 'floor_id' => 48, 'occupied_space' => 100, 'is_actual' => true],
            ['product_id' => 12, 'floor_id' => 11, 'occupied_space' => 100, 'is_actual' => true],
            ['product_id' => 13, 'floor_id' => 46, 'occupied_space' => 100, 'is_actual' => true],
            ['product_id' => 14, 'floor_id' => 32, 'occupied_space' => 100, 'is_actual' => true],
            ['product_id' => 15, 'floor_id' => 32, 'occupied_space' => 100, 'is_actual' => true],
            ['product_id' => 16, 'floor_id' => 5, 'occupied_space' => 100, 'is_actual' => true],
            ['product_id' => 14, 'floor_id' => 3, 'occupied_space' => 100, 'is_actual' => false],
            ['product_id' => 15, 'floor_id' => 41, 'occupied_space' => 100, 'is_actual' => false],
            ['product_id' => 16, 'floor_id' => 20, 'occupied_space' => 100, 'is_actual' => false],
            ['product_id' => 17, 'floor_id' => 17, 'occupied_space' => 100, 'is_actual' => false],
            ['product_id' => 18, 'floor_id' => 11, 'occupied_space' => 100, 'is_actual' => false],
            ['product_id' => 19, 'floor_id' => 16, 'occupied_space' => 100, 'is_actual' => false],
            ['product_id' => 20, 'floor_id' => 16, 'occupied_space' => 100, 'is_actual' => true],
            ['product_id' => 21, 'floor_id' => 20, 'occupied_space' => 100, 'is_actual' => true],
            ['product_id' => 22, 'floor_id' => 30, 'occupied_space' => 100, 'is_actual' => true],
            ['product_id' => 23, 'floor_id' => 31, 'occupied_space' => 100, 'is_actual' => true],
            ['product_id' => 24, 'floor_id' => 40, 'occupied_space' => 100, 'is_actual' => true],
            ['product_id' => 25, 'floor_id' => 41, 'occupied_space' => 100, 'is_actual' => true],
            ['product_id' => 23, 'floor_id' => 33, 'occupied_space' => 100, 'is_actual' => false],
            ['product_id' => 24, 'floor_id' => 46, 'occupied_space' => 100, 'is_actual' => false],
            ['product_id' => 25, 'floor_id' => 11, 'occupied_space' => 100, 'is_actual' => false],
            ['product_id' => 31, 'floor_id' => 15, 'occupied_space' => 100, 'is_actual' => true],
            ['product_id' => 32, 'floor_id' => 15, 'occupied_space' => 100, 'is_actual' => true],
            ['product_id' => 33, 'floor_id' => 14, 'occupied_space' => 100, 'is_actual' => true],
            ['product_id' => 34, 'floor_id' => 13, 'occupied_space' => 100, 'is_actual' => true],
            ['product_id' => 35, 'floor_id' => 12, 'occupied_space' => 100, 'is_actual' => true],
          )
        )->create();

    ProductPoint::factory()->count(24)
        ->state(
          new Sequence(
            ['product_id' => 1, 'point_id' => 1],
            ['product_id' => 2, 'point_id' => 1],
            ['product_id' => 3, 'point_id' => 2],
            ['product_id' => 4, 'point_id' => 2],
            ['product_id' => 5, 'point_id' => 3],
            ['product_id' => 6, 'point_id' => 4],
            ['product_id' => 7, 'point_id' => 5],
            ['product_id' => 8, 'point_id' => 5],
            ['product_id' => 17, 'point_id' => 1],
            ['product_id' => 18, 'point_id' => 2],
            ['product_id' => 19, 'point_id' => 3],
            ['product_id' => 26, 'point_id' => 1],
            ['product_id' => 27, 'point_id' => 4],
            ['product_id' => 28, 'point_id' => 5],
            ['product_id' => 29, 'point_id' => 3],
            ['product_id' => 30, 'point_id' => 2],
            ['product_id' => 9, 'point_id' => 6],
            ['product_id' => 10, 'point_id' => 7],
            ['product_id' => 11, 'point_id' => 8],
            ['product_id' => 12, 'point_id' => 9],
            ['product_id' => 13, 'point_id' => 10],
            ['product_id' => 20, 'point_id' => 6],
            ['product_id' => 21, 'point_id' => 7],
            ['product_id' => 22, 'point_id' => 8],
          )
        )->create();
  }
}
