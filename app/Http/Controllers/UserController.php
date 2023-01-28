<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\Visitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:' . config('variables.rol_admin'));
    }

    public function updateVisitCount($path)
    {
        $visit = Visitas::firstOrNew(['ruta' => $path]);
        $visit->increment('contador');
        $visit->save();
    }

    public function index()
    {
        $path = request()->path();
        $this->updateVisitCount($path);
        $visitas = Visitas::where('ruta', $path)->first();

        return view('content.pages.users.pages-user', ['visitas' => $visitas]);
    }

    public function showRegistrationForm()
    {
        $path = request()->path();
        $this->updateVisitCount($path);
        $visitas = Visitas::where('ruta', $path)->first();

        return view('auth.register', ['visitas' => $visitas]);
    }

    protected function store(StoreUserRequest $request)
    {

        $user =  User::create([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'type' => $request->input('type'),
        ]);

        $user->assignRole($request->input('type'));

        return to_route('user.index');
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

        $path = request()->path();
        $basepath = preg_replace('/\/\d+/', '/*', $path);
        $this->updateVisitCount($basepath);
        $visitas = Visitas::where('ruta', $basepath)->first();

        return view('content.pages.users.pages-user-update', ['user' => $user, 'visitas' => $visitas]);
    }

    protected function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return to_route('user.index');
    }
}
