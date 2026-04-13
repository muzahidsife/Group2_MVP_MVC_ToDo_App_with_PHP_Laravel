<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name'    => fake()->randomElement(['urgent', 'important', 'later', 'review', 'bug', 'feature', 'meeting']),
        ];
    }
}
