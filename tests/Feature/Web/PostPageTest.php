<?php

use App\Models\Post;

use function Pest\Laravel\get;

it('renders a published post page by slug', function () {
    $post = Post::factory()->published()->create([
        'slug' => 'portfolio-project',
        'title' => 'Portfolio Project',
    ]);

    $response = get('/posts/'.$post->slug);

    $response->assertSuccessful()->assertSee('Portfolio Project');
});

it('returns not found for draft post pages', function () {
    $post = Post::factory()->draft()->create([
        'slug' => 'hidden-post',
    ]);

    $response = get('/posts/'.$post->slug);

    $response->assertNotFound();
});
