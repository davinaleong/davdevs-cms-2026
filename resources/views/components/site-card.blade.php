@props([
    'title',
    'href' => '#',
    'excerpt' => null,
    'meta' => null,
])

<a href="{{ $href }}" class="group flex h-full flex-col rounded-2xl border border-neutral-200 bg-white/90 p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-primary-300 hover:shadow-md">
    @if ($meta)
        <p class="text-xs font-semibold uppercase tracking-wider text-primary-700">{{ $meta }}</p>
    @endif
    <h3 class="mt-1 font-serif text-2xl font-bold text-neutral-900">{{ $title }}</h3>
    @if ($excerpt)
        <p class="mt-3 text-sm text-neutral-600">{{ $excerpt }}</p>
    @endif
    <span class="mt-4 text-sm font-semibold text-primary-700">Read more</span>
</a>
