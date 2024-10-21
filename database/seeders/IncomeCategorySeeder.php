<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncomeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['Salary', 'Bonus', 'Gift', 'Investment', 'Other'];

        foreach ($data as $category) {
            \App\Models\IncomeCategory::create([
                'name' => $category,
                'description' => $category,
            ]);
        }
    }
}
