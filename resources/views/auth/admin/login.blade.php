@extends('layouts.app')

@section('title', 'Admin login')

@section('content')
    <section class="mx-auto max-w-md rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm">
        <h1 class="font-serif text-3xl font-bold">Admin sign in</h1>
        <p class="mt-2 text-sm text-neutral-600">Use your admin credentials to manage content and users.</p>

        <form class="mt-6 grid gap-4" method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div>
                <label class="mb-1 block text-sm font-semibold" for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-neutral-300 px-3 py-2" />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold" for="password">Password</label>
                <input id="password" name="password" type="password" required class="w-full rounded-lg border border-neutral-300 px-3 py-2" />
            </div>
            <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white">Enter admin panel</button>
        </form>
    </section>
@endsection
