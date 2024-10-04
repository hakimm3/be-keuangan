<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'date',
        'description'
    ];

    public function category(){
        return $this->belongsTo(IncomeCategory::class, 'category_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
