<?php

namespace Tests\Unit;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsPOST extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_of_adding_products()
    {
        $response = $this->postJson('/api/products', [
            [
                "products" => [
                    [
                        "article" => [
                            "value" => "rgerg5",
                            "errors" => []
                        ],
                        "author" => [
                            "value" => "34234",
                            "errors" => []
                        ],
                        "categoryId" => [
                            "value" => "4",
                            "errors" => []
                        ],
                        "number" => [
                            "value" => "450",
                            "errors" => []
                        ],
                        "printDate" => [
                            "value" => "2011-11-11",
                            "errors" => []
                        ],
                        "printingHouse" => [
                            "value" => "wefgwef",
                            "errors" => []
                        ],
                        "publishingHouse" => [
                            "value" => "wefwef",
                            "errors" => []
                        ],
                        "title" => [
                            "value" => "ergerg",
                            "errors" => []
                        ],
                        "yearOfPublication" => [
                            "value" => "2323",
                            "errors" => []
                        ]
                    ]
                ],
                "userId" => "1",
                "warehousePoints" => [1, 13, 19]
            ]
        ]);

        $response->assertStatus(200);
    }
}
