@extends('layouts.user')

@section('title', 'Account Settings')

@section('content')
    <section class="grid gap-4 lg:grid-cols-2">
        <article class="rounded-xl border border-neutral-200 bg-neutral-50 p-4">
            <h2 class="font-semibold">Profile</h2>
            <form class="mt-3 grid gap-3" method="POST" action="{{ route('user.settings.profile') }}">
                @csrf
                @method('PATCH')
                <div>
                    <label class="mb-1 block text-sm font-semibold" for="name">Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" class="w-full rounded-lg border border-neutral-300 px-3 py-2" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold" for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="w-full rounded-lg border border-neutral-300 px-3 py-2" />
                </div>
                <button type="submit" class="w-fit rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white">Update profile</button>
            </form>
        </article>

        <article class="rounded-xl border border-neutral-200 bg-neutral-50 p-4">
            <h2 class="font-semibold">Password</h2>
            <form class="mt-3 grid gap-3" method="POST" action="{{ route('user.settings.password') }}">
                @csrf
                @method('PATCH')
                <div>
                    <label class="mb-1 block text-sm font-semibold" for="current_password">Current password</label>
                    <input id="current_password" name="current_password" type="password" class="w-full rounded-lg border border-neutral-300 px-3 py-2" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold" for="password">New password</label>
                    <input id="password" name="password" type="password" class="w-full rounded-lg border border-neutral-300 px-3 py-2" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold" for="password_confirmation">Confirm new password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="w-full rounded-lg border border-neutral-300 px-3 py-2" />
                </div>
                <button type="submit" class="w-fit rounded-lg border border-neutral-300 px-4 py-2 text-sm font-semibold">Update password</button>
            </form>
        </article>
    </section>

    <section class="mt-4 rounded-xl border border-neutral-200 bg-neutral-50 p-4">
        <h2 class="font-semibold">Two-factor authentication</h2>
        <p class="mt-1 text-sm text-neutral-600">Status: {{ $user->hasTwoFactorEnabled() ? 'Enabled' : 'Not enabled' }}</p>
        <div class="mt-3 flex flex-wrap gap-2">
            <form method="POST" action="/auth/2fa/setup">
                @csrf
                <button type="submit" class="rounded-lg border border-neutral-300 px-3 py-2 text-xs font-semibold">Generate setup payload</button>
            </form>
            <form method="POST" action="/auth/2fa/recovery-codes/regenerate">
                @csrf
                <button type="submit" class="rounded-lg border border-neutral-300 px-3 py-2 text-xs font-semibold">Regenerate codes</button>
            </form>
            <form method="POST" action="/auth/2fa/recovery-codes/download">
                @csrf
                <button type="submit" class="rounded-lg border border-neutral-300 px-3 py-2 text-xs font-semibold">Download codes</button>
            </form>
        </div>
    </section>
@endsection
