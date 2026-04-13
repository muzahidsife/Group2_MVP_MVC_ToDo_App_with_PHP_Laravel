<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_category(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('categories.store'), [
            'name' => 'Work',
        ]);

        $this->assertDatabaseHas('categories', ['name' => 'Work', 'user_id' => $user->id]);
    }

    public function test_user_cannot_delete_others_category(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $cat = Category::factory()->create(['user_id' => $other->id]);

        $this->actingAs($user)
             ->delete(route('categories.destroy', $cat))
             ->assertForbidden();
    }
}
