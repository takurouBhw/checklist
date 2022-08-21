<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @group login-post
     * @test
     * @return void
     */
    public function ログインすることができる()
    {

        $data = [
            'email' => 'test@test.com',
            'password' =>  '123456789'
        ];

        $response = $this->postJson('/api/login', $data);

        dd($response->json());
        $response->assertStatus(402);
    }
}
