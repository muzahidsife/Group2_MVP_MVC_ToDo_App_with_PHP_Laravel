<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Demo user
        $user = User::factory()->create([
            'name'  => 'Demo User',
            'email' => 'demo@example.com',
        ]);

        // Categories for demo user
        $categories = collect(['Work', 'Personal', 'Shopping', 'Health'])->map(
            fn ($name) => Category::factory()->create(['user_id' => $user->id, 'name' => $name])
        );

        // Tags for demo user
        $tags = collect(['urgent', 'important', 'later', 'review'])->map(
            fn ($name) => Tag::factory()->create(['user_id' => $user->id, 'name' => $name])
        );

        // Tasks for demo user
        Task::factory(20)->create([
            'user_id'     => $user->id,
            'category_id' => fn () => $categories->random()->id,
        ])->each(function ($task) use ($tags) {
            $task->tags()->attach($tags->random(rand(0, 3))->pluck('id'));
        });

        // Additional random users with data
        User::factory(3)->create()->each(function ($u) {
            $cats = Category::factory(2)->create(['user_id' => $u->id]);
            $tgs  = Tag::factory(3)->create(['user_id' => $u->id]);

            Task::factory(10)->create([
                'user_id'     => $u->id,
                'category_id' => fn () => $cats->random()->id,
            ])->each(fn ($t) => $t->tags()->attach($tgs->random(rand(0, 2))->pluck('id')));
        });
    }
}
