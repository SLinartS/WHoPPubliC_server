<?php

namespace Database\Factories;

use App\Models\ProductFloor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductFloor>
 */
class ProductFloorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = ProductFloor::class;

    public function definition()
    {
        return [
            'product_id' => fake()->numberBetween(1, 30),
            'floor_id' => fake()->numberBetween(1, 48),
            'occupied_space' => 100,
            'is_actual' => true,
        ];
    }
}
