<?php

use App\Models\Post;
use App\Models\Tool;

use function Pest\Laravel\get;

it('renders tool hydration container for tool posts', function () {
    $post = Post::factory()->published()->create([
        'post_type' => 'tool',
        'slug' => 'calc-tool',
    ]);

    Tool::factory()->create([
        'post_id' => $post->id,
        'component_name' => 'CalculatorTool',
        'bundle_path' => '/tools/calculator.js',
    ]);

    $response = get('/posts/'.$post->slug);

    $response
        ->assertSuccessful()
        ->assertSee('data-tool-mount', false)
        ->assertSee('CalculatorTool')
        ->assertSee('/tools/calculator.js');
});
