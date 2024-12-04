<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    public $fillable = ['budget_group_id', 'spending_category_id', 'amount'];

    
    public function group(){
        return $this->belongsTo(BudgetGroup::class);
    }
    
    public function spendingCategory(){
        return $this->belongsTo(SpendingCategories::class, 'spending_category_id');
    }
}
