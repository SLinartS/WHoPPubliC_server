<?php

namespace Database\Factories;

use App\Models\LocationHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LocationHistory>
 */
class LocationHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = LocationHistory::class;

    public function definition()
    {
        return [
            'product_id' => fake()->numberBetween(1,10),
            'floor_id' => fake()->numberBetween(1,24),
            'point_id' => fake()->numberBetween(1,10),
            'time' => fake()->dateTime()
        ];
    }
}
