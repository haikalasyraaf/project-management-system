<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::paginate(10);
        $permissions = Permission::all()->groupBy('module_name');

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/roles", 'name' => __('Role')],
            ['name' => __('List')]
        ];

        return view('role.index', compact('breadcrumbs', 'roles', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $role = Role::find($request->role_id);
        $role->permissions()->sync($request->permissions);

        return response()->json(['message' => 'success']);
    }
}
