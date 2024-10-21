<?php

namespace Database\Seeders;

use App\Models\UserWallet;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserWalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wallets = Wallet::all();
        foreach ($wallets as $wallet) {
            UserWallet::create([
                'user_id' => 1,
                'wallet_id' => $wallet->id,
                'description' => 'Wallet ' . $wallet->name,
                'balance' => 200000,
                'monthly_fee' => 0,
                'status' => 1,
            ]);
        }
    }
}
