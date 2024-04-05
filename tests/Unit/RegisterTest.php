<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }


    public function testUserCanRegister(): void
    {
        $userData = [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $response = $this->postJson('api/register', $userData);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'user created successfully']);
        $this->assertDatabaseHas('users', [
            'first_name' => 'Test',
            'email' => 'test@example.com',
        ]);
    }
    public function testRegistrationFailsWithEmptyPassword(): void
    {
        $userData = [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => '',
        ];

        $response = $this->postJson('api/register', $userData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('password');
    }

    public function testRegistrationFailsWithInvalidEmail(): void
    {
        $userData = [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'not an email',
            'password' => 'password',
        ];

        $response = $this->postJson('api/register', $userData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    public function testRegistrationFailsWithEmptyData(): void
    {
        $userData = [];

        $response = $this->postJson('api/register', $userData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['first_name', 'last_name', 'email', 'password']);
    }

}
