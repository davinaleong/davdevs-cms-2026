@extends('layouts.app')

@section('title', 'About')
@section('meta_description', 'About this CMS-driven platform.')

@section('content')
    <section class="mx-auto max-w-3xl space-y-6 rounded-2xl border border-neutral-200 bg-white/90 p-8 shadow-sm">
        <h1 class="font-serif text-4xl font-bold">About</h1>
        <p class="text-neutral-700">
            {{ config('app.name') }} is a structured publishing platform where projects, tools, and jokes share one content model.
            The website, admin panel, and member area all run inside the same Laravel application.
        </p>
        <div class="grid gap-3 md:grid-cols-2">
            <div class="rounded-xl bg-neutral-100 p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-neutral-500">Stack</p>
                <p class="mt-1 text-sm font-semibold">Laravel 13 + Tailwind 4 + Pest 4</p>
            </div>
            <div class="rounded-xl bg-neutral-100 p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-neutral-500">Focus</p>
                <p class="mt-1 text-sm font-semibold">Fast editing, clean rendering, secure auth</p>
            </div>
        </div>
    </section>
@endsection
