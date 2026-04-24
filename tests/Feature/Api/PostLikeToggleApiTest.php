<?php

use App\Models\Post;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\postJson;

it('requires authentication to toggle likes', function () {
    $post = Post::factory()->published()->create([
        'slug' => 'liked-post',
    ]);

    $response = postJson('/api/posts/'.$post->slug.'/likes/toggle');

    $response->assertUnauthorized();
});

it('toggles like and unlike for authenticated users', function () {
    $post = Post::factory()->published()->create([
        'slug' => 'liked-post',
    ]);

    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $firstResponse = postJson('/api/posts/'.$post->slug.'/likes/toggle');
    $firstResponse
        ->assertSuccessful()
        ->assertJsonPath('data.liked', true)
        ->assertJsonPath('data.likes_count', 1);

    $secondResponse = postJson('/api/posts/'.$post->slug.'/likes/toggle');
    $secondResponse
        ->assertSuccessful()
        ->assertJsonPath('data.liked', false)
        ->assertJsonPath('data.likes_count', 0);
});
