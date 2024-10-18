<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use HasFactory, SoftDeletes;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable = [
        'user_id',
        'category_id',
        'user_wallet_id',
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

    public function userWallet(){
        return $this->belongsTo(UserWallet::class, 'user_wallet_id');
    }

    public function wallet() : \Znck\Eloquent\Relations\BelongsToThrough
    {
        return $this->belongsToThrough(Wallet::class, UserWallet::class);
    }
}
