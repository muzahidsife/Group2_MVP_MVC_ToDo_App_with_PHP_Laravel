<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_can_be_marked_completed(): void
    {
        $task = Task::factory()->create(['status' => 'pending']);
        $task->markCompleted();

        $this->assertEquals('completed', $task->fresh()->status);
        $this->assertNotNull($task->fresh()->completed_at);
    }

    public function test_task_can_be_marked_pending(): void
    {
        $task = Task::factory()->create(['status' => 'completed', 'completed_at' => now()]);
        $task->markPending();

        $this->assertEquals('pending', $task->fresh()->status);
        $this->assertNull($task->fresh()->completed_at);
    }

    public function test_overdue_detection(): void
    {
        $task = Task::factory()->create([
            'status'   => 'pending',
            'due_date' => now()->subDay(),
        ]);

        $this->assertTrue($task->isOverdue());
    }
}
