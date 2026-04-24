@extends('layouts.admin')

@section('title', 'Manage Posts')
@section('panel_title', 'Posts')

@section('content')
    <section class="rounded-xl border border-neutral-200 bg-white p-4">
        <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
            <form method="GET" class="flex flex-wrap gap-2">
                <select name="post_type" class="rounded-lg border border-neutral-300 px-3 py-2 text-sm">
                    <option value="">All types</option>
                    @foreach ($postTypes as $postType)
                        <option value="{{ $postType->value }}" @selected(request('post_type') === $postType->value)>{{ $postType->value }}</option>
                    @endforeach
                </select>
                <select name="status" class="rounded-lg border border-neutral-300 px-3 py-2 text-sm">
                    <option value="">All statuses</option>
                    <option value="draft" @selected(request('status') === 'draft')>draft</option>
                    <option value="published" @selected(request('status') === 'published')>published</option>
                </select>
                <button type="submit"
                    class="rounded-lg border border-neutral-300 px-3 py-2 text-sm font-semibold">Filter</button>
            </form>
            <a href="{{ route('admin.posts.create') }}"
                class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white">New post</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-neutral-100 text-xs uppercase tracking-wider text-neutral-600">
                    <tr>
                        <th class="px-3 py-2">Title</th>
                        <th class="px-3 py-2">Type</th>
                        <th class="px-3 py-2">Status</th>
                        <th class="px-3 py-2">Published</th>
                        <th class="px-3 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr class="border-t border-neutral-200">
                            <td class="px-3 py-2 font-semibold">{{ $post->title }}</td>
                            <td class="px-3 py-2">{{ $post->post_type?->value ?? $post->post_type }}</td>
                            <td class="px-3 py-2">{{ $post->status }}</td>
                            <td class="px-3 py-2">{{ optional($post->published_at)?->format('Y-m-d') ?? '-' }}</td>
                            <td class="px-3 py-2">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.posts.edit', $post) }}"
                                        class="rounded border border-neutral-300 px-2 py-1 text-xs">Edit</a>
                                    <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                                        onsubmit="return confirm('Delete this post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="rounded border border-rose-300 px-2 py-1 text-xs text-rose-700">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-3 py-4 text-neutral-500">No posts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $posts->links() }}</div>
    </section>
@endsection
