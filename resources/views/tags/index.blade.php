@extends('layouts.app')
@section('title', 'Tags')

@section('content')
<h1 class="text-2xl font-bold mb-6">Tags</h1>

{{-- Create --}}
<form method="POST" action="{{ route('tags.store') }}" class="bg-white dark:bg-gray-800 rounded-xl p-4 mb-6 shadow-sm border border-gray-200 dark:border-gray-700 flex items-end space-x-3">
    @csrf
    <div class="flex-1">
        <label class="block text-sm font-medium mb-1">Tag Name</label>
        <input type="text" name="name" required placeholder="Tag name"
               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm">
    </div>
    <button type="submit" class="bg-indigo-600 text-white text-sm px-4 py-2.5 rounded-lg hover:bg-indigo-700 transition font-semibold">Add</button>
</form>

{{-- List --}}
<div class="flex flex-wrap gap-2">
    @forelse($tags as $tag)
        <div class="bg-white dark:bg-gray-800 rounded-full px-4 py-2 shadow-sm border border-gray-200 dark:border-gray-700 flex items-center space-x-2">
            <span class="text-sm font-medium">#{{ $tag->name }}</span>
            <span class="text-xs text-gray-400">({{ $tag->tasks_count }})</span>
            <form method="POST" action="{{ route('tags.destroy', $tag) }}" class="inline" onsubmit="return confirm('Delete?')">
                @csrf @method('DELETE')
                <button class="text-gray-400 hover:text-red-500 text-xs ml-1">✕</button>
            </form>
        </div>
    @empty
        <p class="text-gray-400 text-center py-8 w-full">No tags yet.</p>
    @endforelse
</div>
@endsection
