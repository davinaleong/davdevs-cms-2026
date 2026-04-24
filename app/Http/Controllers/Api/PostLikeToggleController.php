<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostLikeToggleController extends Controller
{
    public function __invoke(Request $request, Post $post): JsonResponse
    {
        $user = $request->user();

        $existingLike = Like::query()
            ->where('post_id', $post->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $liked = false;
        } else {
            Like::query()->create([
                'post_id' => $post->id,
                'user_id' => $user->id,
            ]);

            $liked = true;
        }

        return response()->json([
            'data' => [
                'liked' => $liked,
                'likes_count' => $post->likes()->count(),
            ],
        ]);
    }
}
