{{-- resources/views/settings/edit-user.blade.php - New view for editing users (fetches real user data from DB) --}}
@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit User</h1>
        <p class="text-gray-600 dark:text-gray-300">Update user details.</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <form action="{{ route('settings.users.update', $user->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                <input type="text" name="full_name" value="{{ $user->full_name }}" required
                       class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" required
                       class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                <select name="role" required
                        class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="hr" {{ $user->role === 'hr' ? 'selected' : '' }}>HR</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password (leave blank to keep current)</label>
                <input type="password" name="password" placeholder="New password"
                       class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <input type="password" name="password_confirmation" placeholder="Confirm new password"
                       class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update User</button>
                <a href="{{ route('settings.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection