<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Income>
 */
class IncomeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::get()->random()->id,
            'category_id' => \App\Models\IncomeCategory::get()->random()->id,
            'amount' => fake()->numberBetween(10000, 20000),
            'date' => fake()->date(),
            'description' => fake()->text(10)
        ];
    }
}
