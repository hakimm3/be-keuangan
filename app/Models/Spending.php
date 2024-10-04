<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spending extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = ['id', 'user_id', 'category_id', 'description', 'date', 'amount'];

    public function category()
    {
        return $this->belongsTo(SpendingCategories::class, 'category_id');
    }
}
