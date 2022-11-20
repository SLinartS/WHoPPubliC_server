<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class POSTProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_of_adding_products()
    {
        $response = $this->post(
            '/api/products',
            [
                "products" => [
                    [
                        "fields" => [
                            "article" => [
                                "value" => fake()->word(),
                                "errors" => []
                            ],
                            "author" => [
                                "value" => fake()->name(),
                                "errors" => []
                            ],
                            "categoryId" => [
                                "value" => fake()->numberBetween(1, 5),
                                "errors" => []
                            ],
                            "number" => [
                                "value" => fake()->numberBetween(300, 550),
                                "errors" => []
                            ],
                            "printDate" => [
                                "value" => "2011-11-11",
                                "errors" => []
                            ],
                            "printingHouse" => [
                                "value" => fake()->sentence(2, false),
                                "errors" => []
                            ],
                            "publishingHouse" => [
                                "value" => fake()->sentence(2, false),
                                "errors" => []
                            ],
                            "title" => [
                                "value" => fake()->sentence(3, false),
                                "errors" => []
                            ],
                            "yearOfPublication" => [
                                "value" => "2012",
                                "errors" => []
                            ]
                        ],
                        "points" => [2]
                    ],
                    [

                        "fields" => [
                            "article" => [
                                "value" => fake()->word(),
                                "errors" => []
                            ],
                            "author" => [
                                "value" => fake()->name(),
                                "errors" => []
                            ],
                            "categoryId" => [
                                "value" => fake()->numberBetween(1, 5),
                                "errors" => []
                            ],
                            "number" => [
                                "value" => fake()->numberBetween(300, 550),
                                "errors" => []
                            ],
                            "printDate" => [
                                "value" => "2011-11-11",
                                "errors" => []
                            ],
                            "printingHouse" => [
                                "value" => fake()->sentence(2, false),
                                "errors" => []
                            ],
                            "publishingHouse" => [
                                "value" => fake()->sentence(2, false),
                                "errors" => []
                            ],
                            "title" => [
                                "value" => fake()->sentence(3, false),
                                "errors" => []
                            ],
                            "yearOfPublication" => [
                                "value" => "2012",
                                "errors" => []
                            ]
                        ],
                        "points" => [2]
                    ],
                ],
                "userId" => 1,
                "points" => [1, 2, 3],
            ]
        );
        // dd($response->baseResponse);
        $response->assertStatus(200);
    }
}
