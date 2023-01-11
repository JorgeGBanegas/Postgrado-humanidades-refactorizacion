<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('content.pages.users.pages-user');
    }

    protected function create(StoreUserRequest $request)
    {

        $user =  User::create([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'type' => $request->input('type'),
        ]);

        $user->assignRole($request->input('type'));

        return to_route('users.index');
    }

    protected function update(UpdateUserRequest $request, $id)
    {

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'password' => Hash::make($request->input('password')),
            'type' => $request->input('type'),
        ]);

        $user->roles()->detach();
        $user->assignRole($request->input('type'));

        return to_route('user.index');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('content.pages.users.pages-user-update', ['user' => $user]);
    }

    protected function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return to_route('user.index');
    }
}
