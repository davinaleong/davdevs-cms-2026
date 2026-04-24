@extends('layouts.admin')

@section('title', $joke->exists ? 'Edit Joke' : 'Create Joke')
@section('panel_title', $joke->exists ? 'Edit Joke' : 'Create Joke')

@section('content')
    <section class="max-w-2xl rounded-xl border border-neutral-200 bg-white p-5">
        <form class="grid gap-4" method="POST" action="{{ $action }}">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif

            <div>
                <label class="mb-1 block text-sm font-semibold" for="type">Type</label>
                <select id="type" name="type" class="w-full rounded-lg border border-neutral-300 px-3 py-2">
                    <option value="statement" @selected(old('type', $joke->type) === 'statement')>Statement</option>
                    <option value="qa" @selected(old('type', $joke->type) === 'qa')>Q/A</option>
                </select>
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold" for="question">Question (for Q/A)</label>
                <input id="question" name="question" type="text" value="{{ old('question', $joke->question) }}" class="w-full rounded-lg border border-neutral-300 px-3 py-2" />
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold" for="answer">Answer</label>
                <textarea id="answer" name="answer" rows="4" required class="w-full rounded-lg border border-neutral-300 px-3 py-2">{{ old('answer', $joke->answer) }}</textarea>
            </div>

            <label class="inline-flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $joke->is_active ?? true))>
                Active joke
            </label>

            <div class="flex gap-2">
                <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white">Save joke</button>
                <a href="{{ route('admin.jokes.index') }}" class="rounded-lg border border-neutral-300 px-4 py-2.5 text-sm font-semibold">Back</a>
            </div>
        </form>
    </section>
@endsection
