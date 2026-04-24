@extends('layouts.app')

@section('title', 'Home')
@section('meta_description', 'A pragmatic CMS-powered website for articles, tools, and fun.')

@section('content')
    <section class="grid gap-8 lg:grid-cols-[1.2fr_1fr] lg:items-end">
        <div class="space-y-4">
            <p class="inline-flex rounded-full border border-primary-200 bg-primary-50 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-primary-700">
                CMS-powered publishing
            </p>
            <h1 class="font-serif text-4xl font-bold leading-tight text-neutral-900 md:text-5xl">Build. Share. Iterate.</h1>
            <p class="max-w-2xl text-base text-neutral-700 md:text-lg">
                Welcome to {{ config('app.name') }}. Discover practical project writeups, interactive tools, and premium joke refresh perks for signed-in users.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('articles.index') }}" class="rounded-lg bg-primary-600 px-5 py-3 text-sm font-semibold text-white hover:bg-primary-700">Browse articles</a>
                <a href="{{ route('tools.index') }}" class="rounded-lg border border-neutral-300 px-5 py-3 text-sm font-semibold text-neutral-800 hover:border-primary-300 hover:text-primary-700">Explore tools</a>
            </div>
        </div>
        <div class="rounded-2xl border border-neutral-200 bg-white/90 p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-neutral-500">Quick links</p>
            <div class="mt-4 grid gap-2 text-sm">
                <a href="{{ route('jokes.index') }}" class="rounded-md px-3 py-2 hover:bg-neutral-100">Random jokes</a>
                <a href="{{ route('contact') }}" class="rounded-md px-3 py-2 hover:bg-neutral-100">Contact</a>
                <a href="{{ route('admin.login.form') }}" class="rounded-md px-3 py-2 hover:bg-neutral-100">Admin panel</a>
            </div>
        </div>
    </section>

    <section class="mt-12">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="font-serif text-3xl font-bold">Featured</h2>
            <a href="{{ route('articles.index') }}" class="text-sm font-semibold text-primary-700">View all</a>
        </div>

        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($featuredPosts as $post)
                <x-site-card
                    :title="$post->title"
                    :excerpt="$post->excerpt"
                    :meta="$post->post_type?->value"
                    :href="$post->post_type?->value === 'tool' ? route('tools.show', $post) : route('articles.show', $post)"
                />
            @empty
                <p class="rounded-xl border border-neutral-200 bg-white p-4 text-sm text-neutral-600">No featured content yet.</p>
            @endforelse
        </div>
    </section>
@endsection
