<section class="rounded-lg border border-gray-200 p-4">
    <h2 class="mb-2 text-xl font-semibold">{{ $block->payload['title'] ?? 'Section' }}</h2>
    <p class="text-gray-700">{{ $block->payload['body'] ?? '' }}</p>
</section>
