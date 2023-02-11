<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  protected $model = Task::class;

  public function definition()
  {
    return [
        'article' => fake()->unique()->randomLetter() . fake()->randomNumber(2, true) . fake()->randomLetter(),
        'time_start' => fake()->date() . ' ' . fake()->time(),
        'time_end' => fake()->date() . ' ' . fake()->time(),
        'time_completion' => fake()->date() . ' ' . fake()->time(),
        'is_active' => false,
        'user_id' => fake()->numberBetween(1, 1),
        'type_id' => fake()->numberBetween(1, 2),
    ];
  }
}
