<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpendingCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['Food', 'Transportation', 'Household', 'Health', 'Education', 'Entertainment', 'Clothing', 'Insurance', 'Credit Card', 'Other'];
        foreach ($data as $category) {
            \App\Models\SpendingCategories::create([
                'name' => $category,
                'description' => $category,
            ]);
        }
    }
}
