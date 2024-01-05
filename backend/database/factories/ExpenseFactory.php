<?php
// database/factories/ExpenseFactory.php

namespace Database\Factories;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    public function definition()
    {
        return [
            'description' => fake()->sentence,
            'date' => now()->subDays(rand(1, 20)),
            'user_id' => User::inRandomOrder()->first()->id,
            'value' => fake()->randomFloat(2, 1, 1000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
