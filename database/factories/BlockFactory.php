<?php

namespace Database\Factories;

use App\Models\Block;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Block>
 */
class BlockFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  protected $model = Block::class;

  public function definition()
  {
    return [
        'number' => fake()->numberBetween(1, 12),
        'section_id' => fake()->numberBetween(1, 6),
    ];
  }
}
