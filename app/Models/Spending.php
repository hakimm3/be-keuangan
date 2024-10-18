<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spending extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable = ['id', 'user_id', 'category_id', 'user_wallet_id', 'description', 'date', 'amount'];

    public function category()
    {
        return $this->belongsTo(SpendingCategories::class, 'category_id');
    }

    public function userWallet()
    {
        return $this->belongsTo(UserWallet::class, 'user_wallet_id');
    }

    public function wallet() :  \Znck\Eloquent\Relations\BelongsToThrough
    {
        return $this->belongsToThrough(Wallet::class, UserWallet::class);
    }
}
