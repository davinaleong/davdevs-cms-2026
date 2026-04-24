@extends('layouts.app')

@section('title', 'Tools')
@section('meta_description', 'Browse interactive tools and experiments.')

@section('content')
    <section>
        <div class="mb-6 flex items-end justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-neutral-500">Interactive</p>
                <h1 class="font-serif text-4xl font-bold">Tools</h1>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($tools as $tool)
                <x-site-card
                    :title="$tool->title"
                    :excerpt="$tool->excerpt"
                    meta="Tool"
                    :href="route('tools.show', $tool)"
                />
            @empty
                <p class="rounded-xl border border-neutral-200 bg-white p-4 text-sm text-neutral-600">No active tools yet.</p>
            @endforelse
        </div>

        <div class="mt-6">{{ $tools->links() }}</div>
    </section>
@endsection
