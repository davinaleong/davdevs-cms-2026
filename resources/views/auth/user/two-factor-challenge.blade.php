@extends('layouts.app')

@section('title', 'Two-factor challenge')

@section('content')
    <section class="mx-auto max-w-md rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm">
        <h1 class="font-serif text-3xl font-bold">Two-factor challenge</h1>
        <p class="mt-3 text-sm text-neutral-600">Enter an authenticator code or a recovery code to complete login.</p>

        <form class="mt-6 grid gap-4" method="POST" action="/auth/2fa/verify">
            @csrf
            <div>
                <label class="mb-1 block text-sm font-semibold" for="code">Authenticator code</label>
                <input id="code" name="code" type="text" class="w-full rounded-lg border border-neutral-300 px-3 py-2" />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold" for="recovery_code">Recovery code</label>
                <input id="recovery_code" name="recovery_code" type="text" class="w-full rounded-lg border border-neutral-300 px-3 py-2" />
            </div>
            <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white">Verify</button>
        </form>
    </section>
@endsection
