@extends('layouts.admin')

@section('title', 'Manage Jokes')
@section('panel_title', 'Jokes')

@section('content')
    <section class="rounded-xl border border-neutral-200 bg-white p-4">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-neutral-600">Joke management</h2>
            <a href="{{ route('admin.jokes.create') }}" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white">New joke</a>
        </div>

        <ul class="space-y-2">
            @forelse ($jokes as $joke)
                <li class="rounded-lg border border-neutral-200 p-3">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <p class="text-sm font-semibold">{{ strtoupper($joke->type) }} • {{ $joke->is_active ? 'active' : 'inactive' }}</p>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.jokes.edit', $joke) }}" class="rounded border border-neutral-300 px-2 py-1 text-xs">Edit</a>
                            <form method="POST" action="{{ route('admin.jokes.destroy', $joke) }}" onsubmit="return confirm('Delete this joke?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded border border-rose-300 px-2 py-1 text-xs text-rose-700">Delete</button>
                            </form>
                        </div>
                    </div>
                    @if ($joke->question)
                        <p class="mt-2 text-sm text-neutral-700"><span class="font-semibold">Q:</span> {{ $joke->question }}</p>
                    @endif
                    <p class="mt-1 text-sm text-neutral-700"><span class="font-semibold">A:</span> {{ $joke->answer }}</p>
                </li>
            @empty
                <li class="text-sm text-neutral-500">No jokes available.</li>
            @endforelse
        </ul>

        <div class="mt-4">{{ $jokes->links() }}</div>
    </section>
@endsection
