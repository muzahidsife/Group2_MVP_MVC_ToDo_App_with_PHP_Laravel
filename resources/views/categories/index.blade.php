@extends('layouts.app')
@section('title', 'Categories')

@section('content')
<h1 class="text-2xl font-bold mb-6">Categories</h1>

{{-- Create --}}
<form method="POST" action="{{ route('categories.store') }}" class="bg-white dark:bg-gray-800 rounded-xl p-4 mb-6 shadow-sm border border-gray-200 dark:border-gray-700 flex items-end space-x-3">
    @csrf
    <div class="flex-1">
        <label class="block text-sm font-medium mb-1">Name</label>
        <input type="text" name="name" required placeholder="Category name"
               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Color</label>
        <input type="color" name="color" value="#6366f1" class="h-10 w-14 rounded-lg border-gray-300 cursor-pointer">
    </div>
    <button type="submit" class="bg-indigo-600 text-white text-sm px-4 py-2.5 rounded-lg hover:bg-indigo-700 transition font-semibold">Add</button>
</form>

{{-- List --}}
<div class="space-y-2">
    @forelse($categories as $cat)
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="w-4 h-4 rounded-full" style="background-color: {{ $cat->color }}"></span>
                <span class="font-medium">{{ $cat->name }}</span>
                <span class="text-xs text-gray-400">({{ $cat->tasks_count }} tasks)</span>
            </div>
            <form method="POST" action="{{ route('categories.destroy', $cat) }}" onsubmit="return confirm('Delete this category?')">
                @csrf @method('DELETE')
                <button class="text-gray-400 hover:text-red-500 text-sm">Delete</button>
            </form>
        </div>
    @empty
        <p class="text-gray-400 text-center py-8">No categories yet.</p>
    @endforelse
</div>
@endsection
