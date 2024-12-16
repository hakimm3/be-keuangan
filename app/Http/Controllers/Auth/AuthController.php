<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        
        $credentials = $request->only('email', 'password');

        //if auth failed
        if(!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Anda salah'
            ], 401);
        }

        //if auth success
        return response()->json([
            'success' => true,
            'user'    => Auth::guard('api')->user(),    
            'token'   => $token,
            'permissions' => Auth::guard('api')->user()->getAllPermissions()->pluck('name')
        ], 200);
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil logout'
        ], 200);
    }

    public function me()
    {
        return response()->json([
            'success' => true,
            'user'    => Auth::guard('api')->user(),
            'data' => Auth::guard('api')->user()->getAllPermissions()->pluck('name')
        ], 200);
    }
}
