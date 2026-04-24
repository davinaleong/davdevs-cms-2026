@extends('layouts.admin')

@section('title', 'Force Password Change')
@section('panel_title', 'Force Password Change')

@section('content')
    <section class="max-w-xl rounded-2xl border border-neutral-200 bg-white p-5">
        <p class="mb-4 text-sm text-neutral-600">For security, update your initial admin password before continuing.</p>

        <form class="grid gap-4" method="POST" action="{{ route('admin.force-password.update') }}">
            @csrf
            <div>
                <label class="mb-1 block text-sm font-semibold" for="current_password">Current password</label>
                <input id="current_password" name="current_password" type="password" required class="w-full rounded-lg border border-neutral-300 px-3 py-2" />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold" for="password">New password</label>
                <input id="password" name="password" type="password" required class="w-full rounded-lg border border-neutral-300 px-3 py-2" />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold" for="password_confirmation">Confirm new password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full rounded-lg border border-neutral-300 px-3 py-2" />
            </div>
            <button type="submit" class="w-fit rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white">Update password</button>
        </form>
    </section>
@endsection
