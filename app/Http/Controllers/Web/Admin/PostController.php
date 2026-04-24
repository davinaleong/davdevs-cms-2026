<?php

namespace App\Http\Controllers\Web\Admin;

use App\Enums\PostType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $posts = Post::query()
            ->when($request->filled('post_type'), fn ($query) => $query->where('post_type', $request->string('post_type')->toString()))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')->toString()))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.posts.index', [
            'posts' => $posts,
            'postTypes' => PostType::cases(),
        ]);
    }

    public function create(): View
    {
        return view('admin.posts.form', [
            'post' => new Post,
            'postTypes' => PostType::cases(),
            'method' => 'POST',
            'action' => route('admin.posts.store'),
        ]);
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $post = Post::query()->create([
            'title' => $validated['title'],
            'post_type' => $validated['post_type'],
            'slug' => $validated['slug'],
            'excerpt' => $validated['excerpt'] ?? null,
            'content_md' => $validated['content_md'],
            'status' => $validated['status'],
            'published_at' => $validated['published_at'] ?? null,
        ]);

        $post->meta()->create($validated['meta'] ?? []);

        if (! empty($validated['tool'])) {
            $post->tool()->create($validated['tool']);
        }

        if (! empty($validated['blocks'])) {
            $post->blocks()->createMany($validated['blocks']);
        }

        return redirect()->route('admin.posts.index')->with('status', 'Post created.');
    }

    public function show(Post $post): RedirectResponse
    {
        return redirect()->route('admin.posts.edit', $post);
    }

    public function edit(Post $post): View
    {
        $post->load(['meta', 'blocks', 'tool']);

        return view('admin.posts.form', [
            'post' => $post,
            'postTypes' => PostType::cases(),
            'method' => 'PUT',
            'action' => route('admin.posts.update', $post),
        ]);
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $validated = $request->validated();

        $post->update([
            'title' => $validated['title'],
            'post_type' => $validated['post_type'],
            'slug' => $validated['slug'],
            'excerpt' => $validated['excerpt'] ?? null,
            'content_md' => $validated['content_md'],
            'status' => $validated['status'],
            'published_at' => $validated['published_at'] ?? null,
        ]);

        $post->meta()->updateOrCreate([], $validated['meta'] ?? []);
        $post->blocks()->delete();

        if (! empty($validated['blocks'])) {
            $post->blocks()->createMany($validated['blocks']);
        }

        if (! empty($validated['tool'])) {
            $post->tool()->updateOrCreate([], $validated['tool']);
        } else {
            $post->tool()->delete();
        }

        return redirect()->route('admin.posts.edit', $post)->with('status', 'Post updated.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('status', 'Post deleted.');
    }
}
