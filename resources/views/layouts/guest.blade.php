<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-6">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">✓ ToDo App</h1>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
            @yield('content')
        </div>
    </div>
</body>
</html>
