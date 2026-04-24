<?php

use App\Enums\PostType;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewPostPublishedNotification;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

it('lists published posts', function () {
    Post::factory()->published()->count(2)->create();
    Post::factory()->draft()->create();

    $response = getJson('/api/posts');

    $response->assertSuccessful();
    expect($response->json('data'))->toHaveCount(2);
});

it('filters posts by type', function () {
    Post::factory()->published()->create(['post_type' => PostType::Project->value]);
    Post::factory()->published()->create(['post_type' => PostType::Tool->value]);

    $response = getJson('/api/posts?type=project');

    $response->assertSuccessful();
    expect($response->json('data'))->toHaveCount(1);
    expect($response->json('data.0.post_type'))->toBe('project');
});

it('shows a published post by slug', function () {
    $post = Post::factory()->published()->create([
        'slug' => 'my-first-post',
    ]);

    $response = getJson('/api/posts/'.$post->slug);

    $response->assertSuccessful()->assertJsonPath('data.slug', 'my-first-post');
});

it('creates a post with meta and blocks', function () {
    $response = postJson('/api/posts', [
        'title' => 'Building an API CMS',
        'post_type' => PostType::Project->value,
        'slug' => 'building-an-api-cms',
        'excerpt' => 'A quick summary.',
        'content_md' => '# Intro',
        'status' => 'published',
        'published_at' => now()->toISOString(),
        'meta' => [
            'meta_title' => 'Custom Meta Title',
            'meta_description' => 'Custom Meta Description',
            'canonical_url' => 'https://example.com/posts/building-an-api-cms',
        ],
        'blocks' => [
            [
                'type' => 'text',
                'position' => 1,
                'payload' => [
                    'title' => 'Problem',
                    'body' => 'Need structured blocks.',
                ],
            ],
        ],
        'tool' => [
            'component_name' => 'CalculatorTool',
            'bundle_path' => '/tools/calculator.js',
            'props' => [
                'mode' => 'simple',
            ],
            'is_active' => true,
        ],
    ]);

    $response->assertCreated();
    expect(Post::query()->count())->toBe(1);
    expect($response->json('data.tool.component_name'))->toBe('CalculatorTool');
});

it('updates a post', function () {
    $post = Post::factory()->create([
        'status' => 'draft',
    ]);

    $response = putJson('/api/posts/'.$post->slug, [
        'title' => 'Updated title',
        'post_type' => $post->post_type,
        'slug' => 'updated-title',
        'status' => 'published',
        'content_md' => 'Updated markdown',
    ]);

    $response->assertSuccessful();
    expect($post->fresh()->slug)->toBe('updated-title');
});

it('deletes a post', function () {
    $post = Post::factory()->create();

    $response = deleteJson('/api/posts/'.$post->slug);

    $response->assertNoContent();
    expect($post->fresh()->deleted_at)->not->toBeNull();
});

it('notifies verified users when a post is published', function () {
    Notification::fake();

    $verifiedUser = User::factory()->create();
    $unverifiedUser = User::factory()->unverified()->create();

    $response = postJson('/api/posts', [
        'title' => 'Published update',
        'post_type' => PostType::Project->value,
        'slug' => 'published-update',
        'excerpt' => 'Summary',
        'content_md' => '# Published',
        'status' => 'published',
        'published_at' => now()->toISOString(),
    ]);

    $response->assertCreated();

    Notification::assertSentTo($verifiedUser, NewPostPublishedNotification::class);
    Notification::assertNotSentTo($unverifiedUser, NewPostPublishedNotification::class);
});
