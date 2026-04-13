<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskDueSoonNotification extends Notification
{
    use Queueable;

    public function __construct(public Task $task) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Task Due Soon: ' . $this->task->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your task "' . $this->task->title . '" is due on ' . $this->task->due_date->format('M d, Y') . '.')
            ->action('View Task', url('/tasks/' . $this->task->id))
            ->line('Don\'t forget to complete it!');
    }
}
