<?php

namespace Database\Factories;

use App\Models\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Point>
 */
class PointFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  protected $model = Point::class;

  public function definition()
  {
    return [
      'title' => fake()->word(),
      'type_id' => fake()->numberBetween(1, 2),
    ];
  }
}
