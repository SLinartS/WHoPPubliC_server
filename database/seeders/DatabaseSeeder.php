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
use App\Models\User;
use App\Models\Zone;
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

        Task::factory()->count(10)->create();
        Category::factory()->count(5)->create();
        Product::factory()->count(10)->create();
        ProductTask::factory()->count(10)->create();

        Zone::factory()->count(3)->create();
        Section::factory()->count(6)->create();
        Block::factory()->count(12)->create();
        Floor::factory()->count(24)->create();

        ProductFloor::factory()->count(10)->create();
        LocationHistory::factory()->count(10)->create();

        Point::factory()->count(10)->create();
        TaskPoint::factory()->count(10)->create();

        // Post::factory(5)
        //     ->state(
        //         new Sequence(
        //             ["img_url" => "postimages/testimg.png"],
        //             ["img_url" => "postimages/testimg2.png"],
        //             ["img_url" => "postimages/testimg3.jpg"]
        //         )
        //     )
        //     ->create();
        // Chapter::factory(10)
        //     ->state(
        //         new Sequence(["number" => 1], ["number" => 2], ["number" => 3])
        //     )
        //     ->state(
        //         new Sequence(
        //             ["post_id" => 1],
        //             ["post_id" => 2],
        //             ["post_id" => 3],
        //             ["post_id" => 4],
        //             ["post_id" => 5]
        //         )
        //     )
        //     ->create();

    }
}
