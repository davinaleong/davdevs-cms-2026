<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostMeta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PostMeta>
 */
class PostMetaFactory extends Factory
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
            'meta_title' => fake()->sentence(8),
            'meta_description' => fake()->sentence(16),
            'canonical_url' => fake()->url(),
            'og_image' => fake()->imageUrl(),
            'json_ld' => [
                '@context' => 'https://schema.org',
                '@type' => 'Article',
                'headline' => fake()->sentence(8),
            ],
        ];
    }
}
