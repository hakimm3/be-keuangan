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
        'amount',
        'type',
        'description',
    ];

    public function userWallet()
    {
        return $this->belongsTo(UserWallet::class, 'user_wallet_id');
    }
}
