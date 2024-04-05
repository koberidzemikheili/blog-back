<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class PostCreationTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    /**
     * Test post creation.
     */
    public function testUserCanCreatePost(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Editor');
        $this->actingAs($user);

        $postData = [
            'title' => 'Test Post',
            'body' => 'This is a test post.',
        ];

        $response = $this->postJson('api/posts', $postData);

        $response->assertStatus(201);
        $response->assertJson(['message' => 'post created successfully']);
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'body' => 'This is a test post.',
        ]);
    }

    public function testPostCreationFailsWithEmptyTitle(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $postData = [
            'title' => '',
            'body' => 'This is a test post.',
        ];

        $response = $this->postJson('api/posts', $postData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('title');
    }

    public function testPostCreationFailsWithEmptyBody(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $postData = [
            'title' => 'Test Post',
            'body' => '',
        ];

        $response = $this->postJson('api/posts', $postData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('body');
    }

    public function testPostCreationFailsWithEmptyData(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $postData = [];

        $response = $this->postJson('api/posts', $postData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['title', 'body']);
    }

    public function testUserWithWrongRoleCannotCreatePost(): void
    {

        $user = User::factory()->create();
        $user->assignRole('User');

        $this->actingAs($user);

        $postData = [
            'title' => 'Test Post',
            'body' => 'This is a test post.',
        ];
        $response = $this->postJson('api/posts', $postData);

        $response->assertStatus(403);
    }
}
