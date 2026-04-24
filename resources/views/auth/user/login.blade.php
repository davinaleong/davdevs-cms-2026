@extends('layouts.app')

@section('title', 'Sign in')

@section('content')
    <section class="mx-auto max-w-md rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm">
        <h1 class="font-serif text-3xl font-bold">Welcome back</h1>
        <p class="mt-2 text-sm text-neutral-600">Sign in to access likes, premium controls, and account settings.</p>

        <form class="mt-6 grid gap-4" method="POST" action="{{ route('login.attempt') }}">
            @csrf
            <div>
                <label class="mb-1 block text-sm font-semibold" for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-neutral-300 px-3 py-2" />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold" for="password">Password</label>
                <input id="password" name="password" type="password" required class="w-full rounded-lg border border-neutral-300 px-3 py-2" />
            </div>
            <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white">Sign in</button>
        </form>

        <a href="{{ route('password.request') }}" class="mt-3 inline-flex text-sm font-semibold text-primary-700">Forgot password?</a>

        <p class="mt-4 text-sm text-neutral-600">
            Need an account?
            <a href="{{ route('register') }}" class="font-semibold text-primary-700">Create one</a>
        </p>
    </section>
@endsection
