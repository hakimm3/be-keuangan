<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Income;
use App\Models\Spending;
use App\Models\IncomeCategory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SpendingCategories;
use App\Models\UserWallet;
use App\Models\UserWalletTransaction;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            WalletSeeder::class,
            UserWalletSeeder::class,

            SpendingCategorySeeder::class,
            SpendingSeeder::class,

            IncomeCategorySeeder::class,
            IncomeSeeder::class,
        ]);

        // User::factory(2)->create();
        // UserWallet::factory(100)->create();

        // SpendingCategories::factory(10)->create();
        // Spending::factory(100)->create();

        // IncomeCategory::factory(10)->create();
        // Income::factory(100)->create();

        // UserWalletTransaction::factory(100)->create();
    }
}
