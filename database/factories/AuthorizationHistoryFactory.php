<?php

namespace Database\Factories;

use App\Models\AuthorizationHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AuthorizationHistory>
 */
class AuthorizationHistoryFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  protected $model = AuthorizationHistory::class;

  public function definition()
  {
    return [
        'time_authorization' => fake()->date() . ' ' . fake()->time(),
        'current_start_time' => '08:00:00',
        'current_end_time' => '20:00:00',
        'user_id' => 1

    ];
  }
}
