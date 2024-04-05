<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class PostDeleteTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    /**
     * Test post deletion.
     */
    public function testUserCanDeletePost(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');

        $this->actingAs($user);

        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson('api/posts/' . $post->id);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'post deleted successfully']);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
