<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserWallet>
 */
class UserWalletFactory extends Factory
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
            'wallet_id' => Wallet::get()->random()->id,
            'balance' => fake()->numberBetween(10000, 20000),
            'monthly_fee' => fake()->numberBetween(1000, 5000),
        ];
    }
}
