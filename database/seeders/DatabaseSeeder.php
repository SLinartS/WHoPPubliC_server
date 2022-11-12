<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Block;
use App\Models\Category;
use App\Models\Floor;
use App\Models\LocationHistory;
use App\Models\Point;
use App\Models\Product;
use App\Models\ProductFloor;
use App\Models\ProductTask;
use App\Models\Role;
use App\Models\Section;
use App\Models\Task;
use App\Models\TaskPoint;
use App\Models\TaskType;
use App\Models\TypeOfTask;
use App\Models\User;
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
        Role::factory()->count(3)->create();
        User::factory()->create();

        TypeOfTask::factory()->count(2)
            ->state(
                (new Sequence(
                    ['type' => 'acceptance'],
                    ['type' => 'shipment']
                ))
            )->create();

        Task::factory()->count(10)->create();
        Category::factory()->count(5)->create();
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
        LocationHistory::factory()->count(10)->create();

        Point::factory()->count(10)->create();
        TaskPoint::factory()->count(10)->create();
    }
}
