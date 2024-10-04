<?php

namespace Database\Factories;

use App\Models\SpendingCategories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Spending>
 */
class SpendingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::get()->random()->id,
            'category_id' => SpendingCategories::get()->random()->id,
            'description' => fake()->text(10),
            'amount'    => fake()->numberBetween(10000, 20000),
            'date' => fake()->dateTimeThisYear(),
        ];
    }
}
