@extends('layouts.app')
@section('title', 'Tasks')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">My Tasks</h1>
    <div class="flex space-x-2">
        <a href="{{ route('tasks.trash') }}" class="text-sm text-gray-500 hover:text-red-500">🗑️ Trash</a>
        <a href="{{ route('tasks.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
            + New Task
        </a>
    </div>
</div>

{{-- Filters --}}
<form method="GET" action="{{ route('tasks.index') }}" class="bg-white dark:bg-gray-800 rounded-xl p-4 mb-6 shadow-sm border border-gray-200 dark:border-gray-700">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tasks..."
               class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm focus:ring-indigo-500 focus:border-indigo-500">

        <select name="status" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm">
            <option value="">All Status</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
        </select>

        <select name="category_id" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>

        <select name="priority" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm">
            <option value="">All Priorities</option>
            <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
            <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
            <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
        </select>

        <div class="flex space-x-2">
            <button type="submit" class="bg-indigo-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-indigo-700 transition flex-1">Filter</button>
            <a href="{{ route('tasks.index') }}" class="bg-gray-200 dark:bg-gray-700 text-sm px-3 py-2 rounded-lg hover:bg-gray-300 transition">Clear</a>
        </div>
    </div>

    {{-- Sort --}}
    <div class="flex items-center space-x-3 mt-3 text-sm text-gray-500">
        <span>Sort:</span>
        <a href="{{ route('tasks.index', array_merge(request()->query(), ['sort' => 'due_date', 'direction' => 'asc'])) }}" class="hover:text-indigo-600">Due Date ↑</a>
        <a href="{{ route('tasks.index', array_merge(request()->query(), ['sort' => 'created_at', 'direction' => 'desc'])) }}" class="hover:text-indigo-600">Newest</a>
        <a href="{{ route('tasks.index', array_merge(request()->query(), ['sort' => 'priority', 'direction' => 'asc'])) }}" class="hover:text-indigo-600">Priority</a>
    </div>
</form>

{{-- Task List --}}
<div class="space-y-2">
    @forelse($tasks as $task)
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 flex items-center justify-between hover:shadow-md transition">
            <div class="flex items-center space-x-4 flex-1">
                <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                    @csrf @method('PATCH')
                    <button class="w-6 h-6 rounded-full border-2 flex items-center justify-center text-xs transition {{ $task->status === 'completed' ? 'bg-green-500 border-green-500 text-white' : 'border-gray-300 hover:border-indigo-400' }}">
                        @if($task->status === 'completed') ✓ @endif
                    </button>
                </form>

                <div class="flex-1">
                    <a href="{{ route('tasks.show', $task) }}" class="font-medium {{ $task->status === 'completed' ? 'line-through text-gray-400' : '' }}">
                        {{ $task->title }}
                    </a>
                    <div class="flex items-center space-x-2 mt-1 text-xs text-gray-500">
                        @if($task->category)
                            <span class="px-2 py-0.5 rounded-full" style="background-color: {{ $task->category->color }}20; color: {{ $task->category->color }}">{{ $task->category->name }}</span>
                        @endif
                        @foreach($task->tags as $tag)
                            <span class="bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded-full">#{{ $tag->name }}</span>
                        @endforeach
                        @if($task->due_date)
                            <span class="{{ $task->isOverdue() ? 'text-red-500 font-semibold' : '' }}">
                                📅 {{ $task->due_date->format('M d') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <span class="text-xs px-2 py-1 rounded-full {{ $task->priority === 'high' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : ($task->priority === 'medium' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400') }}">
                    {{ $task->priority }}
                </span>
                <a href="{{ route('tasks.edit', $task) }}" class="text-gray-400 hover:text-indigo-600">✏️</a>
                <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Move to trash?')">
                    @csrf @method('DELETE')
                    <button class="text-gray-400 hover:text-red-500">🗑️</button>
                </form>
            </div>
        </div>
    @empty
        <div class="bg-white dark:bg-gray-800 rounded-xl p-12 text-center shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-gray-400 text-lg mb-2">No tasks found</p>
            <a href="{{ route('tasks.create') }}" class="text-indigo-600 hover:underline">Create your first task →</a>
        </div>
    @endforelse
</div>

<div class="mt-6">{{ $tasks->links() }}</div>
@endsection
