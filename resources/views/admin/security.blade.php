@extends('layouts.admin')

@section('title', 'Security')
@section('panel_title', 'Security')

@section('content')
    <section class="max-w-3xl rounded-xl border border-neutral-200 bg-white p-5">
        <h2 class="font-semibold">Two-factor management</h2>
        <p class="mt-2 text-sm text-neutral-600">Generate setup data, verify one-time passcodes, and rotate/download recovery codes.</p>

        <div class="mt-5 grid gap-4 md:grid-cols-2">
            <form class="rounded-lg border border-neutral-200 p-4" method="POST" action="/admin/auth/2fa/setup">
                @csrf
                <h3 class="font-semibold">Enable / Reset 2FA setup</h3>
                <p class="mt-1 text-xs text-neutral-600">Returns JSON with secret, otpauth URL, and recovery codes.</p>
                <button type="submit" class="mt-3 rounded-lg bg-primary-600 px-3 py-2 text-xs font-semibold text-white">Generate setup payload</button>
            </form>

            <form class="rounded-lg border border-neutral-200 p-4" method="POST" action="/admin/auth/2fa/recovery-codes/regenerate">
                @csrf
                <h3 class="font-semibold">Regenerate recovery codes</h3>
                <p class="mt-1 text-xs text-neutral-600">Returns copy-ready recovery code text payload.</p>
                <button type="submit" class="mt-3 rounded-lg border border-neutral-300 px-3 py-2 text-xs font-semibold">Regenerate</button>
            </form>

            <form class="rounded-lg border border-neutral-200 p-4" method="POST" action="/admin/auth/2fa/recovery-codes/download">
                @csrf
                <h3 class="font-semibold">Download recovery codes</h3>
                <p class="mt-1 text-xs text-neutral-600">Downloads a .txt bundle for secure offline storage.</p>
                <button type="submit" class="mt-3 rounded-lg border border-neutral-300 px-3 py-2 text-xs font-semibold">Download .txt</button>
            </form>

            <form class="rounded-lg border border-neutral-200 p-4" method="POST" action="/admin/auth/2fa/verify">
                @csrf
                <h3 class="font-semibold">Verify OTP / recovery code</h3>
                <input name="code" type="text" placeholder="OTP code" class="mt-3 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm" />
                <input name="recovery_code" type="text" placeholder="Recovery code" class="mt-2 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm" />
                <button type="submit" class="mt-3 rounded-lg border border-neutral-300 px-3 py-2 text-xs font-semibold">Verify</button>
            </form>
        </div>
    </section>
@endsection
