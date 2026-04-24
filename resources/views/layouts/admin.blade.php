<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=montserrat:400,500,600,700,800|source-code-pro:400,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-neutral-100 text-neutral-900 antialiased">
    <div class="grid min-h-screen grid-cols-1 md:grid-cols-[15rem_1fr]">
        <aside class="border-r border-neutral-200 bg-white px-5 py-6">
            <a href="{{ route('admin.dashboard') }}" class="block text-xl font-bold text-primary-700">Admin</a>
            <nav class="mt-6 grid gap-1 text-sm font-semibold">
                <a href="{{ route('admin.dashboard') }}" class="rounded-md px-3 py-2 hover:bg-primary-50">Dashboard</a>
                <a href="{{ route('admin.posts.index') }}" class="rounded-md px-3 py-2 hover:bg-primary-50">Posts</a>
                <a href="{{ route('admin.jokes.index') }}" class="rounded-md px-3 py-2 hover:bg-primary-50">Jokes</a>
                <a href="{{ route('admin.users.index') }}" class="rounded-md px-3 py-2 hover:bg-primary-50">Users</a>
                <a href="{{ route('admin.security') }}" class="rounded-md px-3 py-2 hover:bg-primary-50">Security</a>
            </nav>
        </aside>

        <div class="flex min-h-screen flex-col">
            <header class="flex items-center justify-between border-b border-neutral-200 bg-white px-6 py-4">
                <h1 class="text-lg font-bold">@yield('panel_title', 'Admin')</h1>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="rounded-md border border-neutral-300 px-3 py-1.5 text-sm">Logout</button>
                </form>
            </header>

            <main class="flex-1 p-6">
                @include('components.flash')
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
