<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostBlock;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PostBlock>
 */
class PostBlockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'type' => 'text',
            'position' => fake()->numberBetween(1, 6),
            'payload' => [
                'title' => fake()->sentence(4),
                'body' => fake()->paragraph(),
            ],
        ];
    }
}
