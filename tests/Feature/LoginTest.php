<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_login(): void
    {
        $credentials = [
            "email" => "marcrodrimartin@gmail.com",
            "password" => "password"
        ];
        $response = $this->post('/api/login', $credentials);

        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) {
            $json->has('credentials')
            ->has('token');
        });


    }
}
