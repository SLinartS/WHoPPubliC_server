<?php

namespace Database\Factories;

use App\Models\TypeOfTask;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskType>
 */
class TypeOfTaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = TypeOfTask::class;

    public function definition()
    {
        return [
            'type' => fake()->unique()->word()
        ];
    }
}
