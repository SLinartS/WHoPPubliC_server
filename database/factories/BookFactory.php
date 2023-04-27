<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'product_id' => fake()->numberBetween(1, 1),
      'author' => fake()->name(),
      'year_of_publication' => fake()->year(),
      'year_of_printing' => fake()->year(),
      'printing_house' => str_replace('.', '', fake()->sentence(2)),
      'publishing_house' => str_replace('.', '', fake()->sentence(2)),
    ];
  }
}
