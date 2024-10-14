<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserWalletTransaction>
 */
class UserWalletTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_wallet_id' => \App\Models\UserWallet::factory(),
            'amount' => $this->faker->numberBetween(1000, 5000),
            'type' => $this->faker->randomElement(['in', 'out']),
            'description' => $this->faker->sentence,
            'date' => $this->faker->date(),
        ];
    }
}
