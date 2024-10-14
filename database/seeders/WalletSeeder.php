<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wallets = [
            [
                'name' => 'Bank BRI',
                'topup_fee' => 0
            ],
            [
                'name' => 'Bank Permata',
                'topup_fee' => 0
            ],
            [
                'name' => 'Dana',
                'topup_fee' => 0
            ],
            [
                'name' => 'ShopeePay',
                'topup_fee' => 1000
            ],
            [
                'name' => 'GoPay',
                'topup_fee' => 1000
            ],
            [
                'name' => 'OVO',
                'topup_fee' => 1000
            ],
            [
                'name' => "Cash",
                'topup_fee' => 0
            ]
        ];

        foreach ($wallets as $wallet) {
            \App\Models\Wallet::create($wallet);
        }
    }
}
