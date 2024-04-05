<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    public function testUserCanLogin(): void
    {
        $userData = [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ];

        $user = \App\Models\User::create($userData);
        $userData = [
            'email' => 'test@example.com',
            'password' => 'password',
            'remember' => true,
        ];

        $response = $this->postJson('api/login', $userData);

        $response->assertStatus(201);
        $response->assertJson(['message' => 'User logged in']);
    }

    public function testLoginFailsWithEmptyPassword(): void
    {
        $userData = [
            'email' => 'test@example.com',
            'password' => '',
            'remember' => true,
        ];

        $response = $this->postJson('api/login', $userData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('password');
    }

    public function testLoginFailsWithInvalidEmail(): void
    {
        $userData = [
            'email' => 'not an email',
            'password' => 'password',
            'remember' => true,
        ];

        $response = $this->postJson('api/login', $userData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    public function testLoginFailsWithEmptyData(): void
    {
        $userData = [];

        $response = $this->postJson('api/login', $userData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'password', 'remember']);
    }
}
