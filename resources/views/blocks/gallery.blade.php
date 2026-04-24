<section class="space-y-3 rounded-xl border border-slate-200 bg-white p-5">
    <h3 class="text-xl font-semibold">Gallery</h3>
    <div class="grid gap-3 sm:grid-cols-2">
        @foreach (($block->payload['images'] ?? []) as $image)
            <figure class="overflow-hidden rounded-lg border border-slate-200">
                <img src="{{ $image['src'] ?? '' }}" alt="{{ $image['alt'] ?? 'Gallery image' }}" class="h-48 w-full object-cover">
            </figure>
        @endforeach
    </div>
</section>
