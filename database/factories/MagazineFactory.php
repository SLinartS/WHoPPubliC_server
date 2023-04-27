<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Magazine>
 */
class MagazineFactory extends Factory
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
      'printing_house' => str_replace('.', '', fake()->sentence(2)),
      'publishing_house' => str_replace('.', '', fake()->sentence(2)),
      'date_of_printing' => fake()->date(),
      'regularity_id' => fake()->numberBetween(1, 3),
      'audience_id' => fake()->numberBetween(1, 3),
    ];
  }
}
