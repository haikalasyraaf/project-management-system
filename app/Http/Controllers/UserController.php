<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/users", 'name' => __('User')],
            ['name' => __('List')]
        ];

        return view('user.index', compact('breadcrumbs', 'users'));
    }

    public function create()
    {
        $roles = Role::all();

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/users", 'name' => __('User')],
            ['name' => __('Create')]
        ];

        return view('user.create', compact('breadcrumbs', 'roles'));
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name      = $request->name;
        $user->email     = $request->email;
        $user->role_type = $request->role_type;
        $user->password  = Hash::make('12341234');
        $user->save();

        $role = Role::where('id', $request->role_id)->first();
        $user->assignRole($role);

        return redirect()->route('user.index');
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/users", 'name' => __('User')],
            ['name' => __('Edit')]
        ];

        return view('user.edit', compact('breadcrumbs', 'roles', 'user'));
    }

    public function update(Request $request, User $user)
    {
        $user = User::find($user->id);
        $user->name      = $request->name;
        $user->email     = $request->email;
        $user->password  = Hash::make('12341234');
        $user->save();

        $role = Role::where('id', $request->role_id)->first();
        $user->assignRole($role);

        return redirect()->route('user.index');
    }

    public function destroy(User $user)
    {
        $user = User::find($user->id);
        $user->delete();

        return redirect()->back();
    }
}
