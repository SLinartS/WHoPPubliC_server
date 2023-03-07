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
        'author' => fake()->name(),
        'year_of_publication' => fake()->year(),
        'number' => fake()->numberBetween(100, 600),
        'year_of_printing' => fake()->date(),
        'printing_house' => str_replace('.', '', fake()->sentence(2)),
        'publishing_house' => str_replace('.', '', fake()->sentence(2)),
        'image_url' => null,
        'user_id' => fake()->numberBetween(1, 1),
        'category_id' => fake()->numberBetween(1, 5),
    ];
  }
}
