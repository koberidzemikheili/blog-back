<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class PostUpdateTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    /**
     * Test post update.
     */
    public function testUserCanUpdatePost(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');

        $this->actingAs($user);

        $post = Post::factory()->create(['user_id' => $user->id]);

        $postData = [
            'title' => 'Updated Post',
            'body' => 'This is an updated test post.',
            'publish_date' => '2022-01-01'
        ];

        $response = $this->putJson("api/posts/{$post->id}", $postData);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'post updated successfully']);
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Post',
            'body' => 'This is an updated test post.',
            'publish_date' => '2022-01-01',
        ]);
    }
    public function testUpdateFailsWithEmptyTitle(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');

        $this->actingAs($user);

        $post = Post::factory()->create(['user_id' => $user->id]);

        $postData = [
            'title' => '',
            'body' => 'This is an updated test post.',
            'publish_date' => '2022-01-01'
        ];

        $response = $this->putJson("api/posts/{$post->id}", $postData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('title');
    }

    public function testUpdateFailsWithEmptyBody(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');

        $this->actingAs($user);

        $post = Post::factory()->create(['user_id' => $user->id]);

        $postData = [
            'title' => 'Updated Post',
            'body' => '',
            'publish_date' => '2022-01-01'
        ];

        $response = $this->putJson("api/posts/{$post->id}", $postData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('body');
    }

    public function testUpdateFailsWithEmptyData(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');

        $this->actingAs($user);

        $post = Post::factory()->create(['user_id' => $user->id]);

        $postData = [];

        $response = $this->putJson("api/posts/{$post->id}", $postData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['title', 'body', 'publish_date']);
    }

}
