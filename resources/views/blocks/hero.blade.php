<section class="rounded-2xl border border-blue-200 bg-blue-50 p-6">
    <h2 class="text-3xl font-bold tracking-tight">{{ $block->payload['title'] ?? 'Hero' }}</h2>
    @if (! empty($block->payload['subtitle']))
        <p class="mt-2 text-blue-900/80">{{ $block->payload['subtitle'] }}</p>
    @endif
</section>
