<?php

use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('shows like button to authenticated users', function () {
    $post = Post::factory()->published()->create([
        'slug' => 'post-like-ui',
        'post_type' => 'project',
    ]);

    actingAs(User::factory()->create());

    $response = get('/posts/'.$post->slug);

    $response
        ->assertSuccessful()
        ->assertSee('Like')
        ->assertSee('data-like-toggle', false);
});

it('shows auth-required like message to guests', function () {
    $post = Post::factory()->published()->create([
        'slug' => 'post-like-ui-guest',
        'post_type' => 'project',
    ]);

    $response = get('/posts/'.$post->slug);

    $response
        ->assertSuccessful()
        ->assertSee('Sign in to like this post.');
});
