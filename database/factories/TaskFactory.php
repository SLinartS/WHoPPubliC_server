<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Task::class;

    public function definition()
    {
        return [
            'title' => fake()->word(),
            'date_start' => fake()->date(),
            'date_end' => fake()->date(),
            'user_id' => fake()->numberBetween(1, 1),
            'type_id' => fake()->numberBetween(1, 2),
        ];
    }
}
