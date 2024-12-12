<?php

namespace Database\Seeders;

use App\Models\BudgetGroup;
use App\Models\SpendingCategories;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BudgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $spendingCategories = SpendingCategories::all();
        foreach(range(1, 12) as $i){
           $budgetGroup = BudgetGroup::create([
                'user_id' => 1,
                'name' => Carbon::createFromDate(null, $i, 1)->format('F Y'),
                'type' => 'monthly',
                'date' => Carbon::createFromDate(null, $i, 1)->format('Y-m-d')
           ]);

            foreach($spendingCategories as $spendingCategory){
                $budgetGroup->budgets()->create([
                    'spending_category_id' => $spendingCategory->id,
                    'amount' => rand(10000, 100000)
                ]);
            }  
        }
    }
}
