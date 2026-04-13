@extends('layouts.app')
@section('title', $task->title)

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-2xl font-bold {{ $task->status === 'completed' ? 'line-through text-gray-400' : '' }}">{{ $task->title }}</h1>
            <p class="text-sm text-gray-500 mt-1">Created {{ $task->created_at->format('M d, Y') }}</p>
        </div>
        <div class="flex space-x-2">
            <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                @csrf @method('PATCH')
                <button class="px-3 py-1.5 text-sm rounded-lg {{ $task->status === 'completed' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }} hover:opacity-80 transition">
                    {{ $task->status === 'completed' ? '↩ Reopen' : '✓ Complete' }}
                </button>
            </form>
            <a href="{{ route('tasks.edit', $task) }}" class="px-3 py-1.5 text-sm bg-indigo-100 text-indigo-700 rounded-lg hover:opacity-80 transition">Edit</a>
            <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Move to trash?')">
                @csrf @method('DELETE')
                <button class="px-3 py-1.5 text-sm bg-red-100 text-red-700 rounded-lg hover:opacity-80 transition">Delete</button>
            </form>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 space-y-4">
        {{-- Meta --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
            <div>
                <span class="text-gray-500 block">Status</span>
                <span class="font-medium {{ $task->status === 'completed' ? 'text-green-600' : 'text-yellow-600' }}">{{ ucfirst($task->status) }}</span>
            </div>
            <div>
                <span class="text-gray-500 block">Priority</span>
                <span class="font-medium {{ $task->priority === 'high' ? 'text-red-600' : ($task->priority === 'medium' ? 'text-yellow-600' : 'text-green-600') }}">{{ ucfirst($task->priority) }}</span>
            </div>
            <div>
                <span class="text-gray-500 block">Category</span>
                <span class="font-medium">{{ $task->category?->name ?? '—' }}</span>
            </div>
            <div>
                <span class="text-gray-500 block">Due Date</span>
                <span class="font-medium {{ $task->isOverdue() ? 'text-red-600' : '' }}">{{ $task->due_date?->format('M d, Y') ?? '—' }}</span>
            </div>
        </div>

        {{-- Tags --}}
        @if($task->tags->count())
        <div>
            <span class="text-gray-500 text-sm block mb-1">Tags</span>
            <div class="flex flex-wrap gap-2">
                @foreach($task->tags as $tag)
                    <span class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded-full text-xs">#{{ $tag->name }}</span>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Description --}}
        @if($task->description)
        <div>
            <span class="text-gray-500 text-sm block mb-1">Description</span>
            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $task->description }}</p>
        </div>
        @endif

        @if($task->completed_at)
        <p class="text-sm text-green-600">✓ Completed on {{ $task->completed_at->format('M d, Y \a\t g:i A') }}</p>
        @endif
    </div>

    {{-- Activity Log --}}
    @if($task->activityLogs->count())
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-semibold mb-4">Activity History</h2>
        @foreach($task->activityLogs->sortByDesc('created_at') as $log)
            <div class="flex items-start space-x-3 py-2 border-b border-gray-100 dark:border-gray-700 last:border-0 text-sm">
                <span class="text-gray-400">{{ $log->created_at->format('M d, g:i A') }}</span>
                <span>{{ $log->description }}</span>
            </div>
        @endforeach
    </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('tasks.index') }}" class="text-sm text-indigo-600 hover:underline">← Back to tasks</a>
    </div>
</div>
@endsection
