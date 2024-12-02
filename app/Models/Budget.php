<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    public $fillable = ['user_id', 'spending_category_id', 'date', 'amount'];

    public function users(){
        return $this->belongsTo(User::class);
    }
    
    public function spendingCategory(){
        return $this->belongsTo(SpendingCategories::class, 'spending_category_id');
    }
}
