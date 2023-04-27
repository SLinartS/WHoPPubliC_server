<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  protected $model = Product::class;

  public function definition()
  {
    return [
        'article' => fake()->randomLetter() . fake()->randomNumber(2, true) . fake()->randomLetter(),
        'title' => str_replace('.', '', fake()->sentence(3, true)),
        'number' => fake()->numberBetween(100, 600),
        'image_url' => null,
        'note' => fake()->sentence(),
        'user_id' => fake()->numberBetween(1, 1),
        'category_id' => fake()->numberBetween(1, 5),
        'product_type_id' => fake()->numberBetween(1, 3),
    ];
  }
}
