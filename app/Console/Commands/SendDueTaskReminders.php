<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\TaskDueSoonNotification;
use Illuminate\Console\Command;

class SendDueTaskReminders extends Command
{
    protected $signature = 'tasks:send-reminders';
    protected $description = 'Send email reminders for tasks due tomorrow';

    public function handle(): void
    {
        $tasks = Task::with('user')
            ->pending()
            ->whereDate('due_date', now()->addDay()->toDateString())
            ->get();

        foreach ($tasks as $task) {
            $task->user->notify(new TaskDueSoonNotification($task));
        }

        $this->info("Sent {$tasks->count()} reminder(s).");
    }
}
