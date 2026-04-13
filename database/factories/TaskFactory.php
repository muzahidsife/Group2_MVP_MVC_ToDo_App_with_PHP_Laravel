<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'completed']);

        return [
            'user_id'      => User::factory(),
            'category_id'  => Category::factory(),
            'title'        => fake()->sentence(4),
            'description'  => fake()->paragraph(),
            'status'       => $status,
            'priority'     => fake()->randomElement(['low', 'medium', 'high']),
            'due_date'     => fake()->optional(0.7)->dateTimeBetween('-1 week', '+2 weeks'),
            'completed_at' => $status === 'completed' ? now() : null,
        ];
    }
}
