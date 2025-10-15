<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if(Auth::attempt($request->only('email', 'password'))){
            $user = Auth::user();

            $token = $user->createToken('admin')->accessToken;

            return response([
                'token' => $token,
                'user' => $user,
            ], Response::HTTP_OK);
        }
        return response([
            'error'=>'Invalid credentials',
        ], Response::HTTP_UNAUTHORIZED);
    }
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('admin')->accessToken;

        return response([
            'token' => $token,
            'user' => $user,
        ], Response::HTTP_CREATED);
    }
}
