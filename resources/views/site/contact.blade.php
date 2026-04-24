@extends('layouts.app')

@section('title', 'Contact')
@section('meta_description', 'Contact the team behind this CMS.')

@section('content')
    <section class="mx-auto max-w-3xl rounded-2xl border border-neutral-200 bg-white/90 p-8 shadow-sm">
        <h1 class="font-serif text-4xl font-bold">Contact</h1>
        <p class="mt-3 text-neutral-700">For collaborations, support, or feature ideas, reach out and we will respond shortly.</p>

        <form class="mt-6 grid gap-4" method="POST" action="#">
            <div>
                <label class="mb-1 block text-sm font-semibold text-neutral-700" for="name">Name</label>
                <input id="name" type="text" class="w-full rounded-lg border border-neutral-300 px-3 py-2" placeholder="Your name" />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-neutral-700" for="email">Email</label>
                <input id="email" type="email" class="w-full rounded-lg border border-neutral-300 px-3 py-2" placeholder="you@example.com" />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-neutral-700" for="message">Message</label>
                <textarea id="message" rows="5" class="w-full rounded-lg border border-neutral-300 px-3 py-2" placeholder="Tell us what you need..."></textarea>
            </div>
            <button type="button" class="w-fit rounded-lg bg-primary-600 px-5 py-2.5 text-sm font-semibold text-white">Send message</button>
        </form>
    </section>
@endsection
