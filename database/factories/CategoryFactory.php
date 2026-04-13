<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name'    => fake()->randomElement(['Work', 'Personal', 'Shopping', 'Health', 'Finance', 'Education']),
            'color'   => fake()->hexColor(),
        ];
    }
}
