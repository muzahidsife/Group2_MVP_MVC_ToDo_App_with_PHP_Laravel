<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    public static function log(Task $task, string $action, ?string $description = null, ?array $changes = null): void
    {
        ActivityLog::create([
            'user_id'     => Auth::id(),
            'task_id'     => $task->id,
            'action'      => $action,
            'description' => $description ?? "Task {$action}: {$task->title}",
            'changes'     => $changes,
        ]);
    }
}
