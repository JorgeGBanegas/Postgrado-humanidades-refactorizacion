<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\UpdatePersonaRequest;
use App\Models\Persona;
use App\Models\TipoUsuario;
use App\Models\Visitas;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class PersonaController extends Controller
{
    public function updateVisitCount($path)
    {
        $visit = Visitas::firstOrNew(['ruta' => $path]);
        $visit->increment('contador');
        $visit->save();
    }

    public function index(Request $request)
    {
        $route = Route::currentRouteName();
        $search = trim($request->input('search'));

        $path = request()->path();
        $this->updateVisitCount($path);
        $visitas = Visitas::where('ruta', $path)->first();
        $listaPersonas = $this->obtenerLista($search);


        return view('content.pages.personas.pages-persona', ['listaPersonas' => $listaPersonas, 'visitas' => $visitas, 'ruta' => $route, 'busqueda' => $search]);
    }


    private function obtenerLista($search)
    {
        $user = Auth::user();
        $listaPersonas = null;
        if ($user->hasRole(config('variables.rol_admin'))) {
            $listaPersonas = Persona::join('tipo_usuario', 'persona.per_tipo', 'tipo_usuario.tipo_us_id')
                ->where(function ($q) use ($search) {
                    $q->where('persona.per_appm', 'ilike', '%' . $search . '%')
                        ->orwhere('persona.per_nom', 'ilike', '%' . $search . '%')
                        ->orwhere('persona.per_ci', 'ilike', '%' . $search . '%');
                })->where('per_tipo', '=', 1)->orwhere('per_tipo', '=', 2)->paginate(5);
        } else if ($user->hasRole(config('variables.rol_admin_progr'))) {
            $listaPersonas = Persona::join('tipo_usuario', 'persona.per_tipo', 'tipo_usuario.tipo_us_id')
                ->where(function ($q) use ($search) {
                    $q->where('persona.per_appm', 'ilike', '%' . $search . '%')
                        ->orwhere('persona.per_nom', 'ilike', '%' . $search . '%')
                        ->orwhere('persona.per_ci', 'ilike', '%' . $search . '%');
                })->where('per_tipo', '=', 2)->paginate(5);
        } else if ($user->hasRole(config('variables.rol_admin_inscrip'))) {
            $listaPersonas = Persona::join('tipo_usuario', 'persona.per_tipo', 'tipo_usuario.tipo_us_id')
                ->where(function ($q) use ($search) {
                    $q->where('persona.per_appm', 'ilike', '%' . $search . '%')
                        ->orwhere('persona.per_nom', 'ilike', '%' . $search . '%')
                        ->orwhere('persona.per_ci', 'ilike', '%' . $search . '%');
                })->where('per_tipo', '=', 1)->paginate(5);
        }
        return $listaPersonas;
    }

    public function create()
    {
        $path = request()->path();
        $this->updateVisitCount($path);
        $visitas = Visitas::where('ruta', $path)->first();

        $tipos = $this->obtenerTipos();
        return view('content.pages.personas.pages-persona-registro', ['listaTipos' => $tipos, 'visitas' => $visitas]);
    }

    private function obtenerTipos()
    {
        $user = Auth::user();
        $tipos = null;
        if ($user->hasRole(config('variables.rol_admin'))) {
            $tipos = TipoUsuario::whereNotIn('tipo_us_id', [3])->get();
        } else if ($user->hasRole(config('variables.rol_admin_progr'))) {
            $tipos = TipoUsuario::where('tipo_us_id', [2])->get();
        } else if ($user->hasRole(config('variables.rol_admin_inscrip'))) {
            $tipos = TipoUsuario::where('tipo_us_id', [1])->get();
        }
        return $tipos;
    }


    public function store(StorePersonaRequest $request)
    {
        $persona = Persona::create([
            'per_ci' => $request->input("per_ci"),
            'per_nom' => $request->input("per_nom"),
            'per_appm' => $request->input("per_appm"),
            'per_prof' => $request->input("per_prof"),
            'per_telf' => $request->input("per_telf"),
            'per_cel' => $request->input("per_cel"),
            'per_email' => $request->input("per_email"),
            'per_fnac' => $request->input("per_fnac"),
            'per_lnac' => $request->input("per_lnac"),
            'per_est' => true,
            'per_create' => now(),
            'per_update' => now(),
            'per_tipo' => $request->input("per_tipo"),
        ]);
        return to_route('personas.index');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $path = request()->path();
        $basepath = preg_replace('/\/\d+/', '/*', $path);
        $this->updateVisitCount($basepath);
        $visitas = Visitas::where('ruta', $basepath)->first();

        $persona = Persona::find($id);
        $tipos = $this->obtenerTipos();
        return view('content.pages.personas.pages-persona-update', ['listaTipos' => $tipos], ['persona' => $persona, 'visitas' => $visitas]);
    }

    public function update(UpdatePersonaRequest $request, $id)
    {
        $persona = Persona::find($id);
        $persona->update([
            'per_ci' => $request->input("per_ci"),
            'per_nom' => $request->input("per_nom"),
            'per_appm' => $request->input("per_appm"),
            'per_prof' => $request->input("per_prof"),
            'per_telf' => $request->input("per_telf"),
            'per_cel' => $request->input("per_cel"),
            'per_email' => $request->input("per_email"),
            'per_fnac' => $request->input("per_fnac"),
            'per_lnac' => $request->input("per_lnac"),
            'per_update' => now(),
            'per_tipo' => $request->input("per_tipo"),
        ]);

        return to_route('personas.index');
    }

    public function destroy($id)
    {

        try {
            $persona = Persona::find($id);
            $persona->delete();
            return to_route('personas.index');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['er' => 'No puedes eliminar existe registros asociados con esta persona']);
        }
    }
}
