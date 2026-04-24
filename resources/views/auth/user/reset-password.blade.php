@extends('layouts.app')

@section('title', 'Reset password')

@section('content')
    <section class="mx-auto max-w-md rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm">
        <h1 class="font-serif text-3xl font-bold">Reset password</h1>
        <p class="mt-2 text-sm text-neutral-600">Submit your email and new password with the token from your inbox.</p>

        <form class="mt-6 grid gap-4" method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ request()->route('token') }}" />
            <div>
                <label class="mb-1 block text-sm font-semibold" for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', request('email')) }}" required class="w-full rounded-lg border border-neutral-300 px-3 py-2" />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold" for="password">New password</label>
                <input id="password" name="password" type="password" required class="w-full rounded-lg border border-neutral-300 px-3 py-2" />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold" for="password_confirmation">Confirm new password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full rounded-lg border border-neutral-300 px-3 py-2" />
            </div>
            <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white">Reset password</button>
        </form>
    </section>
@endsection
