<?php

use App\Models\Joke;

use function Pest\Laravel\getJson;

it('returns a random active joke', function () {
    Joke::factory()->statement()->create(['is_active' => false]);
    Joke::factory()->statement()->create(['answer' => 'Active joke']);

    $response = getJson('/api/jokes/random');

    $response->assertSuccessful()->assertJsonPath('data.answer', 'Active joke');
});

it('returns not found when no active joke exists', function () {
    Joke::factory()->statement()->create(['is_active' => false]);

    $response = getJson('/api/jokes/random');

    $response->assertNotFound();
});
