@extends('layouts.app')
@section('title', 'Trash')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">🗑️ Trash</h1>
    <a href="{{ route('tasks.index') }}" class="text-sm text-indigo-600 hover:underline">← Back to tasks</a>
</div>

<div class="space-y-2">
    @forelse($tasks as $task)
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <div>
                <p class="font-medium text-gray-400 line-through">{{ $task->title }}</p>
                <p class="text-xs text-gray-500">Deleted {{ $task->deleted_at->diffForHumans() }}</p>
            </div>
            <div class="flex space-x-2">
                <form method="POST" action="{{ route('tasks.restore', $task->id) }}">
                    @csrf @method('PATCH')
                    <button class="text-sm bg-green-100 text-green-700 px-3 py-1.5 rounded-lg hover:opacity-80 transition">Restore</button>
                </form>
                <form method="POST" action="{{ route('tasks.force-delete', $task->id) }}" onsubmit="return confirm('Permanently delete?')">
                    @csrf @method('DELETE')
                    <button class="text-sm bg-red-100 text-red-700 px-3 py-1.5 rounded-lg hover:opacity-80 transition">Delete Forever</button>
                </form>
            </div>
        </div>
    @empty
        <div class="bg-white dark:bg-gray-800 rounded-xl p-12 text-center shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-gray-400">Trash is empty.</p>
        </div>
    @endforelse
</div>

<div class="mt-6">{{ $tasks->links() }}</div>
@endsection
