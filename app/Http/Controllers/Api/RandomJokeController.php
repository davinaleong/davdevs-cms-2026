<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Joke;
use Illuminate\Http\JsonResponse;

class RandomJokeController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $joke = Joke::query()->active()->inRandomOrder()->first();

        if (! $joke) {
            return response()->json([
                'message' => 'No jokes available.',
            ], 404);
        }

        return response()->json([
            'data' => [
                'id' => $joke->id,
                'type' => $joke->type,
                'question' => $joke->question,
                'answer' => $joke->answer,
            ],
        ]);
    }
}
