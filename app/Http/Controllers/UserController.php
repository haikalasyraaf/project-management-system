<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "user", 'name' => __('User')],
            ['name' => __('List')]
        ];

        return view('user.index', compact('breadcrumbs', 'users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make('12341234');
        $user->save();

        return redirect()->route('user.index');
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $user = User::find($user->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make('12341234');
        $user->save();

        return redirect()->route('user.index');
    }

    public function destroy(User $user)
    {
        $user = User::find($user->id);
        $user->delete();

        return redirect()->back();
    }
}
