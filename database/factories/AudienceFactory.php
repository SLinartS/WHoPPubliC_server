<?php

namespace Database\Factories;

use App\Models\Audience;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Audience>
 */
class AudienceFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  protected $model = Audience::class;

  public function definition()
  {
    return [
      'title' => fake()->unique()->word(),
      'alias' => fake()->unique()->word(),
    ];
  }
}
