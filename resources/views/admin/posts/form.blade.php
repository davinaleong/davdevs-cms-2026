@extends('layouts.admin')

@section('title', $post->exists ? 'Edit Post' : 'Create Post')
@section('panel_title', $post->exists ? 'Edit Post' : 'Create Post')

@section('content')
    <section class="rounded-xl border border-neutral-200 bg-white p-5">
        <form class="grid gap-4" method="POST" action="{{ $action }}">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif

            <div class="grid gap-4 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-semibold" for="title">Title</label>
                    <input id="title" name="title" type="text" value="{{ old('title', $post->title) }}" required class="w-full rounded-lg border border-neutral-300 px-3 py-2" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold" for="slug">Slug</label>
                    <input id="slug" name="slug" type="text" value="{{ old('slug', $post->slug) }}" required class="w-full rounded-lg border border-neutral-300 px-3 py-2" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold" for="post_type">Post type</label>
                    <select id="post_type" name="post_type" class="w-full rounded-lg border border-neutral-300 px-3 py-2">
                        @foreach ($postTypes as $postType)
                            <option value="{{ $postType->value }}" @selected(old('post_type', $post->post_type?->value ?? $post->post_type) === $postType->value)>
                                {{ $postType->value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold" for="status">Status</label>
                    <select id="status" name="status" class="w-full rounded-lg border border-neutral-300 px-3 py-2">
                        <option value="draft" @selected(old('status', $post->status) === 'draft')>draft</option>
                        <option value="published" @selected(old('status', $post->status) === 'published')>published</option>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold" for="published_at">Published at</label>
                    <input id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\\TH:i')) }}" class="w-full rounded-lg border border-neutral-300 px-3 py-2" />
                </div>
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold" for="excerpt">Excerpt</label>
                <textarea id="excerpt" name="excerpt" rows="3" class="w-full rounded-lg border border-neutral-300 px-3 py-2">{{ old('excerpt', $post->excerpt) }}</textarea>
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold" for="content_md">Content (Markdown)</label>
                <textarea id="content_md" name="content_md" rows="8" required class="w-full rounded-lg border border-neutral-300 px-3 py-2 font-mono text-sm">{{ old('content_md', $post->content_md) }}</textarea>
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold" for="blocks">Blocks JSON</label>
                <textarea id="blocks" name="blocks" rows="6" class="w-full rounded-lg border border-neutral-300 px-3 py-2 font-mono text-sm">{{ old('blocks', json_encode($post->blocks->map(fn ($block) => ['type' => $block->type, 'position' => $block->position, 'payload' => $block->payload])->values(), JSON_PRETTY_PRINT)) }}</textarea>
                <p class="mt-1 text-xs text-neutral-500">Supports block editor data. Add, reorder, or remove blocks in JSON.</p>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-semibold" for="meta">SEO Meta JSON</label>
                    <textarea id="meta" name="meta" rows="6" class="w-full rounded-lg border border-neutral-300 px-3 py-2 font-mono text-sm">{{ old('meta', json_encode($post->meta?->toArray() ?? [], JSON_PRETTY_PRINT)) }}</textarea>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold" for="tool">Tool JSON</label>
                    <textarea id="tool" name="tool" rows="6" class="w-full rounded-lg border border-neutral-300 px-3 py-2 font-mono text-sm">{{ old('tool', json_encode($post->tool?->toArray() ?? [], JSON_PRETTY_PRINT)) }}</textarea>
                    <p class="mt-1 text-xs text-neutral-500">Use for tool component name, bundle path, props, and active flag.</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-2">
                <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white">Save post</button>
                <a href="{{ route('admin.posts.index') }}" class="rounded-lg border border-neutral-300 px-4 py-2.5 text-sm font-semibold">Back</a>
            </div>
        </form>
    </section>
@endsection
