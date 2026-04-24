@extends('layouts.admin')

@section('title', 'Users')
@section('panel_title', 'Users')

@section('content')
    <section class="rounded-xl border border-neutral-200 bg-white p-4">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-neutral-100 text-xs uppercase tracking-wider text-neutral-600">
                    <tr>
                        <th class="px-3 py-2">Name</th>
                        <th class="px-3 py-2">Email</th>
                        <th class="px-3 py-2">Premium</th>
                        <th class="px-3 py-2">Joined</th>
                        <th class="px-3 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-t border-neutral-200">
                            <td class="px-3 py-2 font-semibold">{{ $user->name }}</td>
                            <td class="px-3 py-2">{{ $user->email }}</td>
                            <td class="px-3 py-2">{{ $user->is_premium ? 'Yes' : 'No' }}</td>
                            <td class="px-3 py-2">{{ $user->created_at->format('Y-m-d') }}</td>
                            <td class="px-3 py-2">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.users.show', $user) }}" class="rounded border border-neutral-300 px-2 py-1 text-xs">View</a>
                                    <form method="POST" action="{{ route('admin.users.toggle-premium', $user) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="rounded border border-primary-300 px-2 py-1 text-xs text-primary-700">
                                            {{ $user->is_premium ? 'Revoke premium' : 'Grant premium' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-3 py-4 text-neutral-500">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $users->links() }}</div>
    </section>
@endsection
