<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpendingCategories extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $fillable = ['name', 'description'];

    public function spendings(){
        return $this->hasMany(Spending::class);
    }
}
