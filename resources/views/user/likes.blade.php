@extends('layouts.user')

@section('title', 'Liked Posts')

@section('content')
    <section>
        <h1 class="text-2xl font-bold">Liked posts</h1>
        <p class="mt-1 text-sm text-neutral-600">Your personal reading list from engagement activity.</p>

        <ul class="mt-4 space-y-2">
            @forelse ($likes as $like)
                <li class="rounded-lg border border-neutral-200 bg-neutral-50 p-3">
                    @if ($like->post)
                        <a href="{{ route('posts.show', $like->post) }}" class="font-semibold text-primary-700 hover:underline">{{ $like->post->title }}</a>
                        <p class="mt-1 text-xs uppercase tracking-wider text-neutral-500">{{ $like->post->post_type?->value ?? $like->post->post_type }}</p>
                    @else
                        <p class="text-sm text-neutral-500">Original post is no longer available.</p>
                    @endif
                </li>
            @empty
                <li class="rounded-lg border border-neutral-200 bg-neutral-50 p-3 text-sm text-neutral-500">No liked posts yet.</li>
            @endforelse
        </ul>

        <div class="mt-4">{{ $likes->links() }}</div>
    </section>
@endsection
