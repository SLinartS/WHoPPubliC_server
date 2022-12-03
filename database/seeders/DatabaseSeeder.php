<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AuthorizationHistory;
use App\Models\Block;
use App\Models\Category;
use App\Models\Floor;
use App\Models\LocationHistory;
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
                    ['title' => 'Администратор'],
                    ['title' => 'Оператор склада'],
                    ['title' => 'Работник склада'],
                ))
            )
            ->create();
        User::factory()->count(10)->create();

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

        Point::factory()->count(10)->create();

        Task::factory()->count(18)
            ->state(
                (new Sequence(
                    // 06
                    [
                        'date_start' => '2021-06-17 10:00:00',
                        'date_end' => '2021-06-18 08:00:00',
                        'time_completion' => '2021-06-19 09:00:00',
                        'type_id' => 1
                    ],
                    [
                        'date_start' => '2021-06-17 10:00:00',
                        'date_end' => '2021-06-19 17:00:00',
                        'time_completion' => '2021-06-19 17:00:00',
                        'type_id' => 1
                    ],
                    [
                        'date_start' => '2021-06-17 10:00:00',
                        'date_end' => '2021-06-18 8:00:00',
                        'time_completion' => '2021-06-18 09:00:00',
                        'type_id' => 1
                    ],
                    [
                        'date_start' => '2021-06-17 10:00:00',
                        'date_end' => '2021-06-18 12:00:00',
                        'time_completion' => '2021-06-19 10:00:00',
                        'type_id' => 2
                    ],
                    [
                        'date_start' => '2021-06-17 10:00:00',
                        'date_end' => '2021-06-18 14:00:00',
                        'time_completion' => '2021-06-18 13:00:00',
                        'type_id' => 2
                    ],
                    [
                        'date_start' => '2021-06-17 10:00:00',
                        'date_end' => '2021-06-19 20:00:00',
                        'time_completion' => '2021-06-20 08:00:00',
                        'type_id' => 2
                    ],
                    [
                        'date_start' => '2021-06-17 10:00:00',
                        'date_end' => '2021-06-18 18:00:00',
                        'time_completion' => '2021-06-19 09:00:00',
                        'type_id' => 3
                    ],
                    [
                        'date_start' => '2021-06-17 10:00:00',
                        'date_end' => '2021-06-18 15:00:00',
                        'time_completion' => '2021-06-18 13:00:00',
                        'type_id' => 3
                    ],
                    [
                        'date_start' => '2021-06-17 10:00:00',
                        'date_end' => '2021-06-18 08:00:00',
                        'time_completion' => '2021-06-19 09:00:00',
                        'type_id' => 3
                    ],
                    // 07
                    [
                        'date_start' => '2021-07-17 10:00:00',
                        'date_end' => '2021-07-18 14:00:00',
                        'time_completion' => '2021-07-19 9:00:00',
                        'type_id' => 1
                    ],
                    [
                        'date_start' => '2021-07-17 10:00:00',
                        'date_end' => '2021-07-19 17:00:00',
                        'time_completion' => '2021-07-19 17:00:00',
                        'type_id' => 1
                    ],
                    [
                        'date_start' => '2021-07-17 10:00:00',
                        'date_end' => '2021-07-18 8:00:00',
                        'time_completion' => '2021-07-18 09:00:00',
                        'type_id' => 1
                    ],
                    [
                        'date_start' => '2021-07-17 10:00:00',
                        'date_end' => '2021-07-18 12:00:00',
                        'time_completion' => '2021-07-19 10:00:00',
                        'type_id' => 2
                    ],
                    [
                        'date_start' => '2021-07-17 10:00:00',
                        'date_end' => '2021-07-18 12:00:00',
                        'time_completion' => '2021-07-18 18:00:00',
                        'type_id' => 2
                    ],
                    [
                        'date_start' => '2021-07-17 10:00:00',
                        'date_end' => '2021-07-19 22:00:00',
                        'time_completion' => '2021-07-20 08:00:00',
                        'type_id' => 2
                    ],
                    [
                        'date_start' => '2021-07-17 10:00:00',
                        'date_end' => '2021-07-18 18:00:00',
                        'time_completion' => '2021-07-18 16:00:00',
                        'type_id' => 3
                    ],
                    [
                        'date_start' => '2021-07-17 10:00:00',
                        'date_end' => '2021-07-18 15:00:00',
                        'time_completion' => '2021-07-18 13:00:00',
                        'type_id' => 3
                    ],
                    [
                        'date_start' => '2021-07-17 10:00:00',
                        'date_end' => '2021-07-19 15:00:00',
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

        Product::factory()->count(10)
            ->state(
                new Sequence(
                    ['number' => 100],
                )
            )->create();
        ProductTask::factory()->count(10)->create();

        Zone::factory()->count(3)->create();
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

        ProductFloor::factory()->count(10)
            ->state(
                new Sequence(
                    ['product_id' => 1, 'floor_id' => 1, 'occupied_space' => 100],
                    ['product_id' => 2, 'floor_id' => 1, 'occupied_space' => 100],
                    ['product_id' => 3, 'floor_id' => 2, 'occupied_space' => 100],
                    ['product_id' => 4, 'floor_id' => 3, 'occupied_space' => 100],
                    ['product_id' => 5, 'floor_id' => 4, 'occupied_space' => 100],
                    ['product_id' => 6, 'floor_id' => 5, 'occupied_space' => 100],
                    ['product_id' => 7, 'floor_id' => 5, 'occupied_space' => 100],
                    ['product_id' => 8, 'floor_id' => 6, 'occupied_space' => 100],
                    ['product_id' => 9, 'floor_id' => 7, 'occupied_space' => 100],
                    ['product_id' => 10, 'floor_id' => 8, 'occupied_space' => 100],
                )
            )->create();
        LocationHistory::factory()->count(5)->create();


        ProductPoint::factory()->count(10)->create();
        TaskFloor::factory()->count(10)->create();
    }
}
