<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\UpdatePersonaRequest;
use App\Models\Persona;
use App\Models\TipoUsuario;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content.pages.personas.pages-persona');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipos = $this->obtenerTipos();
        return view('content.pages.personas.pages-persona-registro', ['listaTipos' => $tipos]);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $persona = Persona::find($id);
        $tipos = $this->obtenerTipos();
        return view('content.pages.personas.pages-persona-update', ['listaTipos' => $tipos], ['persona' => $persona]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
