<?php

namespace App\Http\Controllers\MasterData;

use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\WalletRequest;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wallets = Wallet::all();

        return response()->json([
            'status' => 'success',
            'data' => $wallets
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(WalletRequest $request)
    {
        $wallet = Wallet::create($request->validated());

        return response()->json([
            'status' => 'success',
            'data' => $wallet
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(WalletRequest $request, string $id)
    {
        $wallet = Wallet::findOrFail($id);
        $wallet->update($request->validated());

        return response()->json([
            'status' => 'success',
            'data' => $wallet
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $wallet = Wallet::findOrFail($id);
        $wallet->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Wallet deleted successfully'
        ]);
    }
}
