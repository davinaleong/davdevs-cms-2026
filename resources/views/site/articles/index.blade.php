@extends('layouts.app')

@section('title', 'Articles')
@section('meta_description', 'Browse published article posts.')

@section('content')
    <section>
        <div class="mb-6 flex items-end justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-neutral-500">Knowledge base</p>
                <h1 class="font-serif text-4xl font-bold">Articles</h1>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($articles as $article)
                <x-site-card
                    :title="$article->title"
                    :excerpt="$article->excerpt"
                    meta="Project"
                    :href="route('articles.show', $article)"
                />
            @empty
                <p class="rounded-xl border border-neutral-200 bg-white p-4 text-sm text-neutral-600">No published articles yet.</p>
            @endforelse
        </div>

        <div class="mt-6">{{ $articles->links() }}</div>
    </section>
@endsection
