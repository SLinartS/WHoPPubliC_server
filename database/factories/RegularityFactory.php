<?php

namespace Database\Factories;

use App\Models\Regularity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Regularity>
 */
class RegularityFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  protected $model = Regularity::class;

  public function definition()
  {
    return [
      'title' => fake()->unique()->word(),
      'alias' => fake()->unique()->word(),
    ];
  }
}
