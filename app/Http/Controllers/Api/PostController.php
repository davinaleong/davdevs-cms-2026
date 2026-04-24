<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $posts = Post::query()
            ->with(['meta', 'blocks', 'tool'])
            ->published()
            ->when($request->filled('type'), fn ($query) => $query->where('post_type', $request->string('type')->toString()))
            ->latest('published_at')
            ->paginate(12);

        return PostResource::collection($posts);
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        $post = DB::transaction(function () use ($request): Post {
            $validated = $request->validated();

            $post = Post::query()->create(Arr::except($validated, ['meta', 'blocks', 'tool']));

            if (! empty($validated['meta'])) {
                $post->meta()->create($validated['meta']);
            }

            if (! empty($validated['blocks'])) {
                $post->blocks()->createMany(
                    collect($validated['blocks'])
                        ->values()
                        ->map(fn (array $block, int $index): array => [
                            'type' => $block['type'],
                            'position' => $block['position'] ?? ($index + 1),
                            'payload' => $block['payload'],
                        ])
                        ->all(),
                );
            }

            if (! empty($validated['tool'])) {
                $post->tool()->create($validated['tool']);
            }

            return $post->load(['meta', 'blocks', 'tool']);
        });

        return PostResource::make($post)
            ->response()
            ->setStatusCode(201);
    }

    public function show(Post $post): PostResource
    {
        abort_if($post->status !== 'published', 404);

        return PostResource::make($post->load(['meta', 'blocks', 'tool']));
    }

    public function update(UpdatePostRequest $request, Post $post): PostResource
    {
        DB::transaction(function () use ($request, $post): void {
            $validated = $request->validated();

            $post->update(Arr::except($validated, ['meta', 'blocks', 'tool']));

            if (array_key_exists('meta', $validated)) {
                $post->meta()->updateOrCreate([], $validated['meta'] ?? []);
            }

            if (array_key_exists('blocks', $validated)) {
                $post->blocks()->delete();

                if (! empty($validated['blocks'])) {
                    $post->blocks()->createMany(
                        collect($validated['blocks'])
                            ->values()
                            ->map(fn (array $block, int $index): array => [
                                'type' => $block['type'],
                                'position' => $block['position'] ?? ($index + 1),
                                'payload' => $block['payload'],
                            ])
                            ->all(),
                    );
                }
            }

            if (array_key_exists('tool', $validated)) {
                if (! empty($validated['tool'])) {
                    $post->tool()->updateOrCreate([], $validated['tool']);
                } else {
                    $post->tool()->delete();
                }
            }
        });

        return PostResource::make($post->fresh()->load(['meta', 'blocks', 'tool']));
    }

    public function destroy(Post $post): JsonResponse
    {
        $post->delete();

        return response()->json(status: 204);
    }
}
