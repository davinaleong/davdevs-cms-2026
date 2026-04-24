<article class="space-y-8">
    <header class="space-y-3">
        <p class="text-sm font-semibold uppercase tracking-wider text-gray-500">{{ $post->post_type?->value ?? $post->post_type }}</p>
        <h1 class="text-4xl font-bold tracking-tight">{{ $post->title }}</h1>
        @if ($post->excerpt)
            <p class="text-lg text-gray-600">{{ $post->excerpt }}</p>
        @endif

        <div class="pt-2">
            @auth
                <button
                    type="button"
                    class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm font-semibold"
                    data-like-toggle
                    data-post-slug="{{ $post->slug }}"
                >
                    Like
                </button>
                <span class="ml-2 text-sm text-gray-600" data-like-count>{{ $post->likes_count ?? 0 }}</span>
            @else
                <p class="text-sm text-gray-500">Sign in to like this post.</p>
            @endauth
        </div>
    </header>

    <div class="prose max-w-none">{!! nl2br(e($post->content_md)) !!}</div>

    @if ($post->blocks->isNotEmpty())
        <section class="space-y-6">
            @foreach ($post->blocks as $block)
                @includeIf('blocks.' . $block->type, ['block' => $block])
            @endforeach
        </section>
    @endif
</article>
