<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowingProductsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_showing_products(): void
    {
        $token = $this->post('/api/login', ["email" => 'marcrodrimartin@gmail.com', "password" => "password"])->json()['token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/products');
    ;

        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) {
            $json->has('data')
                 ->has('data.0')
                 ->whereType('data', 'array');
        });
    }
}
