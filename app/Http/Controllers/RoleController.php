<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('view', 'roles');
        return response(RoleResource::collection(Role::all()), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('edit', 'roles');
        $name = $request->name;
        $permissions = $request->permissions;
        $role = Role::create(['name' => $name]);
        foreach($permissions as $permission){
            $role->permissions()->attach($permission);
        }
        return response(new RoleResource($role), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize('view', 'roles');
        return response(new RoleResource(Role::find($id)), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('edit', 'roles');
        $name = $request->name;
        $permissions = $request->permissions;
        $role = Role::find($id);
        $role->update(['name' => $name]);
        $role->permissions()->detach();
        foreach($permissions as $permission){
            $role->permissions()->attach($permission);
        }
        return response(new RoleResource($role), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);
        $role->permissions()->detach();
        $role->delete();
        return Role::find($id)->delete();
    }
}
