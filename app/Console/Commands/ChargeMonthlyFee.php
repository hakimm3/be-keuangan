<?php

namespace App\Console\Commands;

use App\Models\Spending;
use App\Models\SpendingCategories;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\UserWalletTransaction;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ChargeMonthlyFee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:charge-monthly-fee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automaticly make spending from wallet to pay monthly fee for the wallet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::beginTransaction();
        $userWallets = UserWallet::with('wallet')->where('monthly_fee', '>', 0)->get();
        
        $spendingCategory = SpendingCategories::whereName('Admin Fee')->get()->first();
        foreach($userWallets as $userWallet){
            $spending = Spending::create([
                'user_id' => $userWallet->user_id,
                'category_id' => $spendingCategory->id,
                'user_wallet_id' => $userWallet->id,
                'description' => 'Admin fee for wallet '. $userWallet->wallet->name,
                'date' => Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d'),
                'amount' => $userWallet->monthly_fee
            ]);

            UserWalletTransaction::create([
                'user_wallet_id' => $userWallet->id,
                'spending_id' => $spending->id,
                'amount' => $spending->amount,
                'description' => $spending->description,
                'date' => $spending->date
            ]);

            $balance = $userWallet->balance - $userWallet->monthly_fee;
            $userWallet->balance = $balance;
            $userWallet->save();
        }
        DB::commit();
    }
}
