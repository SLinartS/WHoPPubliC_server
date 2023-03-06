<?php

namespace Database\Factories;

use App\Models\Floor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Floor>
 */
class FloorFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  protected $model = Floor::class;

  public function definition()
  {
    return [
        'capacity' => fake()->numberBetween(300, 400),
        'number' => fake()->numberBetween(1, 4),
        'block_id' => fake()->numberBetween(1, 12),
    ];
  }
}
