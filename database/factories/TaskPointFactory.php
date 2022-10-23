<?php

namespace Database\Factories;

use App\Models\TaskPoint;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskPoint>
 */
class TaskPointFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = TaskPoint::class;

    public function definition()
    {
        return [
            'task_id' => fake()->numberBetween(1,10),
            'point_id' => fake()->numberBetween(1,10),
        ];
    }
}
