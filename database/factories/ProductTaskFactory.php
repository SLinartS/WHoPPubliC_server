<?php

namespace Database\Factories;

use App\Models\ProductTask;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductTask>
 */
class ProductTaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ProductTask::class;

    public function definition()
    {
        return [
            'product_id' => fake()->numberBetween(1,10),
            'task_id' => fake()->numberBetween(1,10)
        ];
    }
}
