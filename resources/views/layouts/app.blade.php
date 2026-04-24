<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('meta_description', config('app.name'))">
    <link rel="canonical" href="@yield('canonical', request()->url())">
    <meta property="og:title" content="@yield('og_title', config('app.name'))">
    <meta property="og:description" content="@yield('og_description', config('app.name'))">
    <meta property="og:url" content="@yield('canonical', request()->url())">
    <meta property="og:image" content="@yield('og_image', '')">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=montserrat:400,500,600,700,800|playfair-display:600,700|source-code-pro:400,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="bg-neutral-50 text-neutral-900 antialiased">
    <div class="relative min-h-screen">
        <div class="pointer-events-none absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top_right,rgb(191_219_254)_0%,transparent_45%),radial-gradient(circle_at_bottom_left,rgb(226_232_240)_0%,transparent_35%)]"></div>

        <header class="sticky top-0 z-30 border-b border-neutral-200/80 bg-white/85 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
                <a href="{{ route('home') }}" class="font-serif text-2xl font-bold tracking-tight text-primary-700">
                    {{ config('app.name') }}
                </a>
                <nav class="flex items-center gap-2 text-sm font-semibold text-neutral-700">
                    <a href="{{ route('home') }}" class="rounded-md px-3 py-2 hover:bg-primary-50 hover:text-primary-700">Home</a>
                    <a href="{{ route('about') }}" class="rounded-md px-3 py-2 hover:bg-primary-50 hover:text-primary-700">About</a>
                    <a href="{{ route('articles.index') }}" class="rounded-md px-3 py-2 hover:bg-primary-50 hover:text-primary-700">Articles</a>
                    <a href="{{ route('tools.index') }}" class="rounded-md px-3 py-2 hover:bg-primary-50 hover:text-primary-700">Tools</a>
                    <a href="{{ route('jokes.index') }}" class="rounded-md px-3 py-2 hover:bg-primary-50 hover:text-primary-700">Jokes</a>
                    <a href="{{ route('contact') }}" class="rounded-md px-3 py-2 hover:bg-primary-50 hover:text-primary-700">Contact</a>

                    @auth
                        <a href="{{ route('user.dashboard') }}" class="ml-2 rounded-md border border-primary-200 bg-primary-50 px-3 py-2 text-primary-700">Account</a>
                    @else
                        <a href="{{ route('login') }}" class="ml-2 rounded-md border border-primary-200 bg-primary-50 px-3 py-2 text-primary-700">Sign in</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-6 py-10">
            @include('components.flash')
            @yield('content')
        </main>

        <footer class="border-t border-neutral-200 bg-white/80">
            <div class="mx-auto flex max-w-6xl flex-col gap-1 px-6 py-6 text-sm text-neutral-600 md:flex-row md:items-center md:justify-between">
                <p>{{ config('app.name') }} • CMS + website experience</p>
                <p class="font-mono text-xs">Built on Laravel {{ app()->version() }}</p>
            </div>
        </footer>
    </div>
    @stack('scripts')
</body>
</html>
