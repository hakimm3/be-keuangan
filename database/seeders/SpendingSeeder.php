<?php

namespace Database\Seeders;

use App\Models\SpendingCategories;
use App\Models\UserWallet;
use App\Models\UserWalletTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpendingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=0; $i<100; $i++) {
            $spending = \App\Models\Spending::create([
                'user_id' => 1,
                'user_wallet_id' => UserWallet::where('user_id', 1)->get()->random()->id,
                'category_id' => SpendingCategories::all()->random()->id,
                'description' => fake()->sentence,
                'amount' => rand(10000, 100000),
                'date' => fake()->dateTimeBetween('-7 month', 'now'),
            ]);

            UserWalletTransaction::create([
                'user_wallet_id' => $spending->user_wallet_id,
                'spending_id' => $spending->id,
                'type' => 'out',
                'amount' => $spending->amount,
                'description' => $spending->description,
                'date' => $spending->date,
            ]);
        }
    }
}
