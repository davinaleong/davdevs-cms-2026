@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('panel_title', 'Dashboard')

@section('content')
    <section class="grid gap-4 md:grid-cols-3">
        <article class="rounded-xl border border-neutral-200 bg-white p-4">
            <p class="text-xs font-semibold uppercase tracking-wider text-neutral-500">Total posts</p>
            <p class="mt-2 text-3xl font-bold">{{ $totalPosts }}</p>
        </article>
        <article class="rounded-xl border border-neutral-200 bg-white p-4">
            <p class="text-xs font-semibold uppercase tracking-wider text-neutral-500">Drafts</p>
            <p class="mt-2 text-3xl font-bold">{{ $draftPosts }}</p>
        </article>
        <article class="rounded-xl border border-neutral-200 bg-white p-4">
            <p class="text-xs font-semibold uppercase tracking-wider text-neutral-500">Users</p>
            <p class="mt-2 text-3xl font-bold">{{ $totalUsers }}</p>
        </article>
    </section>

    <section class="mt-6 grid gap-4 lg:grid-cols-2">
        <article class="rounded-xl border border-neutral-200 bg-white p-4">
            <h2 class="font-semibold">Recent posts</h2>
            <ul class="mt-3 space-y-2 text-sm">
                @forelse ($recentPosts as $post)
                    <li class="flex items-center justify-between rounded-md bg-neutral-50 px-3 py-2">
                        <span>{{ $post->title }}</span>
                        <span class="text-neutral-500">{{ $post->status }}</span>
                    </li>
                @empty
                    <li class="text-neutral-500">No posts yet.</li>
                @endforelse
            </ul>
        </article>
        <article class="rounded-xl border border-neutral-200 bg-white p-4">
            <h2 class="font-semibold">Recent jokes</h2>
            <ul class="mt-3 space-y-2 text-sm">
                @forelse ($recentJokes as $joke)
                    <li class="rounded-md bg-neutral-50 px-3 py-2">{{ $joke->type }} - {{ \\Illuminate\\Support\\Str::limit($joke->answer, 90) }}</li>
                @empty
                    <li class="text-neutral-500">No jokes yet.</li>
                @endforelse
            </ul>
        </article>
    </section>
@endsection
