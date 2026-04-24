@extends('layouts.app')

@section('title', 'Jokes')
@section('meta_description', 'Random jokes from the CMS')

@section('content')
    <section class="mx-auto max-w-2xl space-y-5">
        <h1 class="font-serif text-4xl font-bold tracking-tight">Jokes</h1>

        @if ($joke)
            <article class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6" data-joke-card>
                @if ($joke->type === 'statement')
                    <p class="text-xl leading-relaxed">{{ $joke->answer }}</p>
                @else
                    <p class="text-lg font-medium">{{ $joke->question }}</p>
                    <button type="button" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white" data-reveal-answer>
                        Reveal answer
                    </button>
                    <p class="hidden text-lg" data-joke-answer>{{ $joke->answer }}</p>
                @endif
            </article>

            @auth
                @if (auth()->user()->is_premium)
                    <a href="{{ route('jokes.index') }}" class="inline-flex rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold">
                        Refresh joke
                    </a>
                @else
                    <button type="button" disabled class="inline-flex cursor-not-allowed rounded-lg border border-amber-300 bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-800">
                        Refresh joke (Premium only)
                    </button>
                    <p class="text-sm text-amber-700">Upgrade to premium for instant joke refresh.</p>
                @endif
            @else
                <a href="{{ route('login') }}" class="inline-flex rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold">
                    Sign in to unlock premium refresh
                </a>
            @endauth
        @else
            <p class="rounded-lg border border-slate-200 p-4">No jokes available yet.</p>
        @endif
    </section>
@endsection
