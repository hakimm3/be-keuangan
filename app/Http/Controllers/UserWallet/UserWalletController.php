<?php

namespace App\Http\Controllers\UserWallet;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserWalletRequest;
use App\Models\UserWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserWalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userWallets = UserWallet::with('user', 'wallet')->where('user_id', Auth::id())->latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $userWallets
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(UserWalletRequest $request)
    {
        // dd($request->all());
        $userWallet = UserWallet::create([
            'user_id' => Auth::id(),
            'description' => $request->description,
            'wallet_id' => $request->wallet_id,
            'balance' => $request->balance,
            'monthly_fee' => $request->monthly_fee,
            'status' => $request->status ? 1 : 0
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $userWallet
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UserWalletRequest $request, string $id)
    {
        // dd($request->all());
        $userWallet = UserWallet::findOrFail($id);
        $userWallet->update([
            'description' => $request->description,
            'wallet_id' => $request->wallet_id,
            'balance' => $request->balance,
            'monthly_fee' => $request->monthly_fee,
            'status' => $request->status ? 1 : 0
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $userWallet
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $userWallet = UserWallet::findOrFail($id);
        $userWallet->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User wallet deleted successfully'
        ]);
    }
}
