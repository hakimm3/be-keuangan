<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1; $i<=100; $i++){
            $income = \App\Models\Income::create([
                'user_id' => 1,
                'user_wallet_id' => \App\Models\UserWallet::where('user_id', 1)->get()->random()->id,
                'category_id' => rand(1, 5),
                'description' => fake()->sentence,
                'amount' => rand(10000, 100000),
                'date' => fake()->dateTimeBetween('-7 month', 'now'),
            ]);

            \App\Models\UserWalletTransaction::create([
                'user_wallet_id' => $income->user_wallet_id,
                'income_id' => $income->id,
                'type' => 'in',
                'amount' => $income->amount,
                'description' => $income->description,
                'date' => $income->date,
            ]);
        }
    }
}
