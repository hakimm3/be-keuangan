<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserWalletTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_wallet_id',
        'spending_id',
        'income_id',
        'amount',
        'type',
        'description',
        'date',
    ];

    public function userWallet()
    {
        return $this->belongsTo(UserWallet::class, 'user_wallet_id');
    }

    public function spending()
    {
        return $this->belongsTo(Spending::class, 'spending_id');
    }

    public function income()
    {
        return $this->belongsTo(Income::class, 'income_id');
    }
}
