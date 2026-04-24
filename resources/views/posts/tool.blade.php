<article class="space-y-8">
	<header class="space-y-3">
		<p class="text-sm font-semibold uppercase tracking-wider text-gray-500">tool</p>
		<h1 class="text-4xl font-bold tracking-tight">{{ $post->title }}</h1>
		@if ($post->excerpt)
			<p class="text-lg text-gray-600">{{ $post->excerpt }}</p>
		@endif
	</header>

	@if ($post->tool && $post->tool->is_active)
		<section
			class="rounded-xl border border-slate-200 p-4"
			data-tool-mount
			data-component-name="{{ $post->tool->component_name }}"
			data-bundle-path="{{ $post->tool->bundle_path }}"
			data-tool-props='@json($post->tool->props ?? [])'
		>
			<p class="text-sm text-gray-500">Loading {{ $post->tool->component_name }}...</p>
			<p class="mt-2 hidden text-sm text-amber-700" data-tool-fallback></p>
			<noscript>
				<p class="mt-2 text-sm text-gray-700">JavaScript is required to run this tool.</p>
			</noscript>
		</section>
	@else
		<p class="rounded-lg border border-slate-200 p-4 text-sm">This tool is currently unavailable.</p>
	@endif

	<div class="prose max-w-none">{!! nl2br(e($post->content_md)) !!}</div>
</article>
