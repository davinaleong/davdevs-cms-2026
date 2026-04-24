<?php

namespace Database\Factories;

use App\Models\Joke;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Joke>
 */
class JokeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => 'statement',
            'question' => null,
            'answer' => fake()->sentence(),
            'is_active' => true,
        ];
    }

    public function statement(): static
    {
        return $this->state(fn () => [
            'type' => 'statement',
            'question' => null,
        ]);
    }

    public function qa(): static
    {
        return $this->state(fn () => [
            'type' => 'qa',
            'question' => fake()->sentence(5),
        ]);
    }
}
