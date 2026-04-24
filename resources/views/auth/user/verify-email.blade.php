@extends('layouts.app')

@section('title', 'Verify email')

@section('content')
    <section class="mx-auto max-w-xl rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm">
        <h1 class="font-serif text-3xl font-bold">Verify your email</h1>
        <p class="mt-3 text-neutral-700">We sent a verification link to your inbox. Verify first, then return here to unlock full account access.</p>

        <form class="mt-5" method="POST" action="/auth/email/verification-notification">
            @csrf
            <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white">Resend verification email</button>
        </form>
    </section>
@endsection
