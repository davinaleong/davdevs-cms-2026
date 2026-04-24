<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'My Account')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=montserrat:400,500,600,700,800|source-code-pro:400,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-neutral-100 text-neutral-900 antialiased">
    <div class="mx-auto grid min-h-screen max-w-6xl grid-cols-1 gap-6 px-4 py-6 md:grid-cols-[14rem_1fr]">
        <aside class="rounded-2xl border border-neutral-200 bg-white p-4">
            <p class="px-2 text-xs font-semibold uppercase tracking-wider text-neutral-500">Account</p>
            <nav class="mt-3 grid gap-1 text-sm font-semibold">
                <a href="{{ route('user.dashboard') }}" class="rounded-md px-3 py-2 hover:bg-primary-50">Dashboard</a>
                <a href="{{ route('user.likes') }}" class="rounded-md px-3 py-2 hover:bg-primary-50">Liked posts</a>
                <a href="{{ route('user.settings.edit') }}" class="rounded-md px-3 py-2 hover:bg-primary-50">Settings</a>
                <a href="{{ route('home') }}" class="rounded-md px-3 py-2 hover:bg-primary-50">Back to site</a>
            </nav>
        </aside>

        <main class="rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm">
            @include('components.flash')
            @yield('content')
        </main>
    </div>
</body>
</html>
