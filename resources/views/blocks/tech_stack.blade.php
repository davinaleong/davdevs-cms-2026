<section class="rounded-xl border border-slate-200 bg-white p-5">
    <h3 class="mb-3 text-xl font-semibold">Tech Stack</h3>
    <ul class="flex flex-wrap gap-2">
        @foreach (($block->payload['items'] ?? []) as $item)
            <li class="rounded-full border border-slate-300 px-3 py-1 text-sm">{{ $item }}</li>
        @endforeach
    </ul>
</section>
