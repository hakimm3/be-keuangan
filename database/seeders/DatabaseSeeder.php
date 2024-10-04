<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Income;
use App\Models\Spending;
use App\Models\IncomeCategory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SpendingCategories;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);

        User::factory(10)->create();
        // SpendingCategories::factory(10)->create();
        // Spending::factory(1000)->create();

        // IncomeCategory::factory(10)->create();
        // Income::factory(1000)->create();
    }
}
