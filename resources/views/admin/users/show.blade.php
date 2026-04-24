@extends('layouts.admin')

@section('title', 'User Details')
@section('panel_title', 'User Details')

@section('content')
    <section class="grid gap-4 lg:grid-cols-[1fr_1fr]">
        <article class="rounded-xl border border-neutral-200 bg-white p-4">
            <h2 class="font-semibold">Profile</h2>
            <dl class="mt-3 grid gap-2 text-sm">
                <div>
                    <dt class="font-semibold text-neutral-500">Name</dt>
                    <dd>{{ $user->name }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-neutral-500">Email</dt>
                    <dd>{{ $user->email }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-neutral-500">Premium</dt>
                    <dd>{{ $user->is_premium ? 'Yes' : 'No' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-neutral-500">2FA enabled</dt>
                    <dd>{{ $user->hasTwoFactorEnabled() ? 'Yes' : 'No' }}</dd>
                </div>
            </dl>
        </article>

        <article class="rounded-xl border border-neutral-200 bg-white p-4">
            <h2 class="font-semibold">Recent liked posts</h2>
            <ul class="mt-3 space-y-2 text-sm">
                @forelse ($likedPosts as $like)
                    <li class="rounded-md bg-neutral-50 px-3 py-2">{{ $like->post?->title ?? 'Deleted post' }}</li>
                @empty
                    <li class="text-neutral-500">No likes recorded.</li>
                @endforelse
            </ul>
        </article>
    </section>
@endsection
