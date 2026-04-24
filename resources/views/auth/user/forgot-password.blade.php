@extends('layouts.app')

@section('title', 'Forgot password')

@section('content')
    <section class="mx-auto max-w-md rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm">
        <h1 class="font-serif text-3xl font-bold">Forgot password</h1>
        <p class="mt-2 text-sm text-neutral-600">Enter your email to receive a reset link.</p>

        <form class="mt-6 grid gap-4" method="POST" action="{{ route('password.email') }}">
            @csrf
            <div>
                <label class="mb-1 block text-sm font-semibold" for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-neutral-300 px-3 py-2" />
            </div>
            <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white">Send reset link</button>
        </form>
    </section>
@endsection
