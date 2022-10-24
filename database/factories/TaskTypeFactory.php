<?php

namespace Database\Factories;

use App\Models\TaskType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskType>
 */
class TaskTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = TaskType::class;

    public function definition()
    {
        return [
            'type' => fake()->unique()->word()
        ];
    }
}
