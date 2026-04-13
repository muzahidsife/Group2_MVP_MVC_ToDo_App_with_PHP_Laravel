<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $tasks = $user->tasks()
            ->with(['category', 'tags'])
            ->search($request->input('search'))
            ->filterStatus($request->input('status'))
            ->filterCategory($request->input('category_id'))
            ->filterPriority($request->input('priority'))
            ->when($request->input('sort'), function ($q) use ($request) {
                $dir = $request->input('direction', 'asc');
                match ($request->input('sort')) {
                    'due_date'   => $q->orderByRaw('due_date IS NULL, due_date ' . $dir),
                    'priority'   => $q->orderByRaw("FIELD(priority, 'high','medium','low') " . $dir),
                    'created_at' => $q->orderBy('created_at', $dir),
                    default      => $q->latest(),
                };
            }, fn ($q) => $q->latest())
            ->paginate(15)
            ->withQueryString();

        $categories = $user->categories()->get();

        return view('tasks.index', compact('tasks', 'categories'));
    }

    public function create(Request $request)
    {
        $categories = $request->user()->categories()->get();
        $tags = $request->user()->tags()->get();

        return view('tasks.create', compact('categories', 'tags'));
    }

    public function store(StoreTaskRequest $request)
    {
        $task = $request->user()->tasks()->create($request->validated());

        if ($request->has('tags')) {
            $task->tags()->sync($request->input('tags'));
        }

        ActivityLogService::log($task, 'created');

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Task created successfully!');
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);

        $task->load(['category', 'tags', 'activityLogs']);

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task, Request $request)
    {
        $this->authorize('update', $task);

        $task->load('tags');
        $categories = $request->user()->categories()->get();
        $tags = $request->user()->tags()->get();

        return view('tasks.edit', compact('task', 'categories', 'tags'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $original = $task->only(['title', 'status', 'priority', 'due_date', 'category_id']);

        $task->update($request->validated());

        if ($request->has('tags')) {
            $task->tags()->sync($request->input('tags'));
        }

        ActivityLogService::log($task, 'updated', null, [
            'before' => $original,
            'after'  => $task->only(['title', 'status', 'priority', 'due_date', 'category_id']),
        ]);

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        ActivityLogService::log($task, 'deleted');
        $task->delete(); // soft delete

        return redirect()->route('tasks.index')
            ->with('success', 'Task moved to trash.');
    }

    public function toggleStatus(Task $task)
    {
        $this->authorize('update', $task);

        if ($task->status === 'pending') {
            $task->markCompleted();
            ActivityLogService::log($task, 'completed');
            $message = 'Task marked as completed!';
        } else {
            $task->markPending();
            ActivityLogService::log($task, 'reopened');
            $message = 'Task marked as pending.';
        }

        return back()->with('success', $message);
    }

    public function trash(Request $request)
    {
        $tasks = $request->user()->tasks()
            ->onlyTrashed()
            ->with('category')
            ->latest('deleted_at')
            ->paginate(15);

        return view('tasks.trash', compact('tasks'));
    }

    public function restore(int $id, Request $request)
    {
        $task = $request->user()->tasks()->onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $task);

        $task->restore();
        ActivityLogService::log($task, 'restored');

        return redirect()->route('tasks.trash')
            ->with('success', 'Task restored successfully!');
    }

    public function forceDelete(int $id, Request $request)
    {
        $task = $request->user()->tasks()->onlyTrashed()->findOrFail($id);
        $this->authorize('delete', $task);

        $task->forceDelete();

        return redirect()->route('tasks.trash')
            ->with('success', 'Task permanently deleted.');
    }
}
