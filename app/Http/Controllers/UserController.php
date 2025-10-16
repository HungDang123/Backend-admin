<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
class UserController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('view', 'users');
        $users = UserResource::collection(User::with('roles')->paginate());
        return $users;
    }
    public function show($id)
    {
        Gate::authorize('view', 'users');
        $user = User::with('roles')->find($id);
        return new UserResource($user);
    }
    public function store(UserRequest $request)
    {
        Gate::authorize('edit', 'users');
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);
        if($request->role_id){
            $user->roles()->attach($request->role_id);
        }
        return new UserResource($user);
    }
    public function update($id, UserUpdateRequest $request)
    {
        Gate::authorize('edit', 'users');
        $user = User::with('roles')->find($id);
        $user->update($request->only('first_name', 'last_name', 'email'));
        return new UserResource($user);
    }
    public function destroy($id)
    {
        $user = User::with('roles')->find($id);
        $user->delete();
        return [];
    }
}
