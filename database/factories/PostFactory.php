<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Post::class;
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'publish_date' => function() {
                return now()->toDateString();
            },
            'user_id' => function (array $attributes) {
                if (isset($attributes['user_id'])) {
                    return $attributes['user_id'];
                }
                return User::factory()->create()->id;
            },
        ];
    }
}
