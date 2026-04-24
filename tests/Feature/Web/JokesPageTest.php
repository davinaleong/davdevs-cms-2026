<?php

use App\Models\Joke;

use function Pest\Laravel\get;

it('renders statement jokes immediately', function () {
    Joke::factory()->statement()->create([
        'answer' => 'A statement joke',
    ]);

    $response = get('/jokes');

    $response->assertSuccessful()->assertSee('A statement joke');
});

it('renders qa jokes with reveal button', function () {
    Joke::factory()->qa()->create([
        'question' => 'Why?',
        'answer' => 'Because.',
    ]);

    $response = get('/jokes');

    $response
        ->assertSuccessful()
        ->assertSee('Why?')
        ->assertSee('Reveal answer');
});
