@extends('layouts.app')
@section('title', 'Create Task')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Create Task</h1>

    <form method="POST" action="{{ route('tasks.store') }}" class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 space-y-4">
        @csrf

        <div>
            <label for="title" class="block text-sm font-medium mb-1">Title *</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-indigo-500 focus:border-indigo-500">
            @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" id="description" rows="4"
                      class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label for="category_id" class="block text-sm font-medium mb-1">Category</label>
                <select name="category_id" id="category_id"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                    <option value="">None</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="priority" class="block text-sm font-medium mb-1">Priority *</label>
                <select name="priority" id="priority"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                    <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                </select>
            </div>

            <div>
                <label for="due_date" class="block text-sm font-medium mb-1">Due Date</label>
                <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}"
                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
            </div>
        </div>

        @if($tags->count())
        <div>
            <label class="block text-sm font-medium mb-2">Tags</label>
            <div class="flex flex-wrap gap-2">
                @foreach($tags as $tag)
                    <label class="inline-flex items-center space-x-1 bg-gray-100 dark:bg-gray-700 px-3 py-1.5 rounded-full text-sm cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="rounded border-gray-300 text-indigo-600"
                            {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                        <span>{{ $tag->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>
        @endif

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('tasks.index') }}" class="px-4 py-2 text-sm rounded-lg bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 transition">Cancel</a>
            <button type="submit" class="px-6 py-2 text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">Create Task</button>
        </div>
    </form>
</div>
@endsection
