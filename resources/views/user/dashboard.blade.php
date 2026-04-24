@extends('layouts.user')

@section('title', 'My Dashboard')

@section('content')
    <section class="grid gap-4 md:grid-cols-2">
        <article class="rounded-xl border border-neutral-200 bg-neutral-50 p-4">
            <p class="text-xs font-semibold uppercase tracking-wider text-neutral-500">Welcome</p>
            <h1 class="mt-1 text-2xl font-bold">Hi, {{ $user->name }}</h1>
            <p class="mt-2 text-sm text-neutral-700">Your account center for likes, premium access, and security settings.</p>
        </article>
        <article class="rounded-xl border border-neutral-200 bg-neutral-50 p-4">
            <p class="text-xs font-semibold uppercase tracking-wider text-neutral-500">Subscription</p>
            <p class="mt-2 text-lg font-semibold">{{ $user->is_premium ? 'Pro' : 'Free' }} plan</p>
            <p class="mt-1 text-sm text-neutral-600">{{ $user->is_premium ? 'Premium joke refresh and feature unlocks are active.' : 'Upgrade path is ready for payment integration.' }}</p>
        </article>
    </section>

    <section class="mt-4 grid gap-4 md:grid-cols-3">
        <article class="rounded-xl border border-neutral-200 bg-white p-4">
            <p class="text-xs font-semibold uppercase tracking-wider text-neutral-500">Liked posts</p>
            <p class="mt-2 text-3xl font-bold">{{ $likesCount }}</p>
        </article>
        <article class="rounded-xl border border-neutral-200 bg-white p-4">
            <p class="text-xs font-semibold uppercase tracking-wider text-neutral-500">2FA</p>
            <p class="mt-2 text-lg font-semibold">{{ $user->hasTwoFactorEnabled() ? 'Enabled' : 'Not enabled' }}</p>
        </article>
        <article class="rounded-xl border border-neutral-200 bg-white p-4">
            <p class="text-xs font-semibold uppercase tracking-wider text-neutral-500">Email verification</p>
            <p class="mt-2 text-lg font-semibold">{{ $user->hasVerifiedEmail() ? 'Verified' : 'Pending' }}</p>
        </article>
    </section>
@endsection
