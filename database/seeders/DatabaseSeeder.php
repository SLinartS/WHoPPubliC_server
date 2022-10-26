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
        Product::factory()->count(10)->create();
        ProductTask::factory()->count(10)->create();

        Zone::factory()->count(3)->create();
        Section::factory()->count(6)->create();
        Block::factory()->count(12)->create();
        Floor::factory()->count(48)
            ->state(
                new Sequence(
                    ['block_id' => 1],
                    ['block_id' => 2],
                    ['block_id' => 3],
                    ['block_id' => 4],
                    ['block_id' => 5],
                    ['block_id' => 6],
                    ['block_id' => 7],
                    ['block_id' => 8],
                    ['block_id' => 9],
                    ['block_id' => 10],
                    ['block_id' => 11],
                    ['block_id' => 12],
                )
            )->create();

        ProductFloor::factory()->count(10)->create();
        LocationHistory::factory()->count(10)->create();

        Point::factory()->count(10)->create();
        TaskPoint::factory()->count(10)->create();
    }
}
