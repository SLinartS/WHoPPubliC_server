<?php

namespace Database\Factories;

use App\Models\ProductPoint;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductPoint>
 */
class ProductPointFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  protected $model = ProductPoint::class;

  public function definition()
  {
    return [
        'product_id' => fake()->numberBetween(1, 10),
        'point_id' => fake()->numberBetween(1, 10),
    ];
  }
}
