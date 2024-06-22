<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  protected $model = User::class;

  public function definition()
  {
    return [
      'email' => fake()->safeEmail(),
      'phone' => fake()->numberBetween(10000000000, 99999999999),
      'login' => fake()->unique()->word(),
      'password' => Hash::make('password'),
      'name' => fake()->firstName(),
      'surname' => fake()->lastName(),
      'patronymic' => fake()->lastName(),
      'is_del' => false,
      'role_id' => fake()->numberBetween(1, 3),
    ];
  }
}
