<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetGroup extends Model
{
    use HasFactory;
    public $fillable = ['user_id', 'name', 'type', 'date'];

    public function budgets(){
        return $this->hasMany(Budget::class);
    }
}
