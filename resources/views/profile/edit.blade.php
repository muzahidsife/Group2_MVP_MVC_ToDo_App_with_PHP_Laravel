@extends('layouts.app')
@section('title', 'Profile')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <h1 class="text-2xl font-bold">Profile Settings</h1>

    {{-- Update Info --}}
    <form method="POST" action="{{ route('profile.update') }}" class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 space-y-4">
        @csrf @method('PATCH')
        <h2 class="text-lg font-semibold">Account Information</h2>

        <div>
            <label for="name" class="block text-sm font-medium mb-1">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
            @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 text-white text-sm px-6 py-2 rounded-lg hover:bg-indigo-700 transition font-semibold">Save</button>
        </div>
    </form>

    {{-- Change Password --}}
    <form method="POST" action="{{ route('profile.password') }}" class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 space-y-4">
        @csrf @method('PATCH')
        <h2 class="text-lg font-semibold">Change Password</h2>

        <div>
            <label for="current_password" class="block text-sm font-medium mb-1">Current Password</label>
            <input type="password" name="current_password" id="current_password" required
                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
            @error('current_password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium mb-1">New Password</label>
            <input type="password" name="password" id="password" required
                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
            @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium mb-1">Confirm New Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 text-white text-sm px-6 py-2 rounded-lg hover:bg-indigo-700 transition font-semibold">Update Password</button>
        </div>
    </form>
</div>
@endsection
