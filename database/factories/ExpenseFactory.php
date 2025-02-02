<?php

namespace Database\Factories;

use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'description' => $this->faker->sentence,
            'amount' => $this->faker->numberBetween(100, 10000),
            'category' => $this->faker->word,
            'receipt_path' => $this->faker->imageUrl(),
            'status_id' => Status::factory()
        ];
    }
}
