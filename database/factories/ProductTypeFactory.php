<?php

namespace Database\Factories;

use App\Models\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductTypeFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  protected $model = ProductType::class;

  public function definition()
  {
    return [
      'title' => fake()->unique()->word(),
      'alias' => fake()->unique()->word(),
    ];
  }
}
