<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Tool;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tool>
 */
class ToolFactory extends Factory
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
            'component_name' => 'CalculatorTool',
            'bundle_path' => '/tools/calculator.js',
            'props' => [
                'theme' => 'light',
            ],
            'is_active' => true,
        ];
    }
}
