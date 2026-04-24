<?php

namespace App\Http\Controllers\Api;

use App\Enums\PostType;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class PostTypeController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'data' => array_map(
                static fn (PostType $type): array => [
                    'name' => str($type->value)->title()->toString(),
                    'value' => $type->value,
                ],
                PostType::cases(),
            ),
        ]);
    }
}
