@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">Dashboard</h1>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
        <p class="text-sm text-gray-500 dark:text-gray-400">Total Tasks</p>
        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
        <p class="text-sm text-gray-500 dark:text-gray-400">Pending</p>
        <p class="text-3xl font-bold text-yellow-500 mt-1">{{ $stats['pending'] }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
        <p class="text-sm text-gray-500 dark:text-gray-400">Completed</p>
        <p class="text-3xl font-bold text-green-500 mt-1">{{ $stats['completed'] }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
        <p class="text-sm text-gray-500 dark:text-gray-400">Overdue</p>
        <p class="text-3xl font-bold text-red-500 mt-1">{{ $stats['overdue'] }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Recent Tasks --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Recent Tasks</h2>
            <a href="{{ route('tasks.create') }}" class="text-sm text-indigo-600 hover:underline">+ New Task</a>
        </div>
        @forelse($recentTasks as $task)
            <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700 last:border-0">
                <div class="flex items-center space-x-3">
                    <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                        @csrf @method('PATCH')
                        <button class="w-5 h-5 rounded-full border-2 flex items-center justify-center {{ $task->status === 'completed' ? 'bg-green-500 border-green-500 text-white' : 'border-gray-300' }}">
                            @if($task->status === 'completed') ✓ @endif
                        </button>
                    </form>
                    <a href="{{ route('tasks.show', $task) }}" class="text-sm {{ $task->status === 'completed' ? 'line-through text-gray-400' : '' }}">{{ $task->title }}</a>
                </div>
                <span class="text-xs px-2 py-1 rounded-full {{ $task->priority === 'high' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : ($task->priority === 'medium' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400') }}">
                    {{ $task->priority }}
                </span>
            </div>
        @empty
            <p class="text-gray-400 text-sm py-4 text-center">No tasks yet. Create your first task!</p>
        @endforelse
    </div>

    {{-- Recent Activity --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-lg font-semibold mb-4">Recent Activity</h2>
        @forelse($recentActivity as $log)
            <div class="flex items-start space-x-3 py-3 border-b border-gray-100 dark:border-gray-700 last:border-0">
                <span class="text-lg">
                    @switch($log->action)
                        @case('created') 📝 @break
                        @case('completed') ✅ @break
                        @case('updated') ✏️ @break
                        @case('deleted') 🗑️ @break
                        @case('restored') ♻️ @break
                        @default 📋
                    @endswitch
                </span>
                <div>
                    <p class="text-sm">{{ $log->description }}</p>
                    <p class="text-xs text-gray-400">{{ $log->created_at->diffForHumans() }}</p>
                </div>
            </div>
        @empty
            <p class="text-gray-400 text-sm py-4 text-center">No activity yet.</p>
        @endforelse
    </div>
</div>
@endsection
