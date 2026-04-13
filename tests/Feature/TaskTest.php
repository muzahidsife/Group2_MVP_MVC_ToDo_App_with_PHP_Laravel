<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_guest_cannot_access_tasks(): void
    {
        $this->get(route('tasks.index'))->assertRedirect(route('login'));
    }

    public function test_user_can_view_task_list(): void
    {
        $this->actingAs($this->user)
             ->get(route('tasks.index'))
             ->assertStatus(200);
    }

    public function test_user_can_create_task(): void
    {
        $response = $this->actingAs($this->user)->post(route('tasks.store'), [
            'title'    => 'Test Task',
            'priority' => 'medium',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', ['title' => 'Test Task', 'user_id' => $this->user->id]);
    }

    public function test_task_requires_title(): void
    {
        $this->actingAs($this->user)
             ->post(route('tasks.store'), ['priority' => 'medium'])
             ->assertSessionHasErrors('title');
    }

    public function test_user_can_update_task(): void
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user)->put(route('tasks.update', $task), [
            'title'    => 'Updated Title',
            'priority' => 'high',
        ]);

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Updated Title']);
    }

    public function test_user_can_delete_task(): void
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user)->delete(route('tasks.destroy', $task));

        $this->assertSoftDeleted('tasks', ['id' => $task->id]);
    }

    public function test_user_can_toggle_task_status(): void
    {
        $task = Task::factory()->create(['user_id' => $this->user->id, 'status' => 'pending']);

        $this->actingAs($this->user)->patch(route('tasks.toggle', $task));

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'completed']);
    }

    public function test_user_cannot_access_others_task(): void
    {
        $otherUser = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $otherUser->id]);

        $this->actingAs($this->user)
             ->get(route('tasks.show', $task))
             ->assertForbidden();
    }

    public function test_user_can_search_tasks(): void
    {
        Task::factory()->create(['user_id' => $this->user->id, 'title' => 'Buy groceries']);
        Task::factory()->create(['user_id' => $this->user->id, 'title' => 'Read book']);

        $this->actingAs($this->user)
             ->get(route('tasks.index', ['search' => 'groceries']))
             ->assertSee('Buy groceries')
             ->assertDontSee('Read book');
    }

    public function test_user_can_filter_by_status(): void
    {
        Task::factory()->create(['user_id' => $this->user->id, 'title' => 'Pending Task', 'status' => 'pending']);
        Task::factory()->create(['user_id' => $this->user->id, 'title' => 'Done Task', 'status' => 'completed']);

        $this->actingAs($this->user)
             ->get(route('tasks.index', ['status' => 'pending']))
             ->assertSee('Pending Task')
             ->assertDontSee('Done Task');
    }

    public function test_user_can_filter_by_priority(): void
    {
        Task::factory()->create(['user_id' => $this->user->id, 'title' => 'High Task', 'priority' => 'high']);
        Task::factory()->create(['user_id' => $this->user->id, 'title' => 'Low Task', 'priority' => 'low']);

        $this->actingAs($this->user)
             ->get(route('tasks.index', ['priority' => 'high']))
             ->assertSee('High Task')
             ->assertDontSee('Low Task');
    }

    public function test_user_can_restore_trashed_task(): void
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);
        $task->delete();

        $this->actingAs($this->user)->patch(route('tasks.restore', $task->id));

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'deleted_at' => null]);
    }
}
