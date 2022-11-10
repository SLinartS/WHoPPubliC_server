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
            'article' => fake()->unique()->word(),
            'title' => fake()->word(),
            'author' => fake()->name(),
            'year_of_publication' => fake()->randomNumber(4, true),
            'number' => fake()->numberBetween(100, 200),
            'print_date' => fake()->date(),
            'printing_house' => fake()->sentence(2),
            'publishing_house' => fake()->sentence(2),
            'stored' => fake()->numberBetween(0, 1),
            'user_id' => fake()->numberBetween(1, 1),
            'category_id' => fake()->numberBetween(1, 5),
        ];
    }
}
