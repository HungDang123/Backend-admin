<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $data = [
            'user' => Auth::user(),
        ];
        return $data;
    }
    public function update(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::user()->id,
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $user = Auth::user();
        $user->update($request->only('first_name', 'last_name', 'email'));
        return $user;
    }
    public function changePassword(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8|same:password',
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $user = Auth::user();
        $user->update(['password' => Hash::make($request->password)]);
        return $user;
    }
}
