<!DOCTYPE html>
<html lang="en" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen">

    {{-- Navigation --}}
    <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-indigo-600 dark:text-indigo-400">
                        ✓ ToDo App
                    </a>
                    @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-medium hover:text-indigo-600 dark:hover:text-indigo-400 {{ request()->routeIs('dashboard') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">Dashboard</a>
                    <a href="{{ route('tasks.index') }}" class="text-sm font-medium hover:text-indigo-600 dark:hover:text-indigo-400 {{ request()->routeIs('tasks.*') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">Tasks</a>
                    <a href="{{ route('categories.index') }}" class="text-sm font-medium hover:text-indigo-600 dark:hover:text-indigo-400 {{ request()->routeIs('categories.*') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">Categories</a>
                    <a href="{{ route('tags.index') }}" class="text-sm font-medium hover:text-indigo-600 dark:hover:text-indigo-400 {{ request()->routeIs('tags.*') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">Tags</a>
                    @endauth
                </div>
                <div class="flex items-center space-x-4">
                    <button id="dark-mode-toggle" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700" title="Toggle dark mode">
                        🌓
                    </button>
                    @auth
                    <a href="{{ route('profile.edit') }}" class="text-sm hover:text-indigo-600">{{ Auth::user()->name }}</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-red-500 hover:text-red-700">Logout</button>
                    </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    {{-- Main Content --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @yield('content')
    </main>

</body>
</html>
