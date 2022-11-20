<?php

namespace Database\Factories;

use App\Models\TaskFloor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TasksFloors>
 */
class TaskFloorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = TaskFloor::class;

    public function definition()
    {
        return [
            'task_id' => fake()->numberBetween(1, 10),
            'floor_id' => fake()->numberBetween(1, 24),
        ];
    }
}
