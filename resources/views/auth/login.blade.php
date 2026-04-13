@extends('layouts.guest')
@section('title', 'Login')

@section('content')
<h2 class="text-2xl font-bold mb-6 text-center text-gray-900 dark:text-white">Sign In</h2>

<form method="POST" action="{{ route('login') }}" class="space-y-4">
    @csrf
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
               class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        @error('email') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
        <input type="password" name="password" id="password" required
               class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    </div>

    <div class="flex items-center">
        <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
        <label for="remember" class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remember me</label>
    </div>

    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg transition">
        Sign In
    </button>
</form>

<p class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
    Don't have an account? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Register</a>
</p>
@endsection
