<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Visitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CarreraController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:' . config('variables.rol_admin') . '|' . config('variables.rol_admin_progr'));
    }

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
        $carreras = Carrera::where('carr_nom', 'ilike', '%' . $search . '%')
            ->orderBy('carr_nom', 'ASC')
            ->paginate(5);
        return view('content.pages.carreras.pages-carreras', ['carreras' => $carreras, 'visitas' => $visitas, 'ruta' => $route, 'busqueda' => $search]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'carr_nom' => 'required|unique:carrera,carr_nom'
        ]);
        Carrera::create($request->all());
        return to_route('carreras.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'carr_nom_edit' => 'required|unique:carrera,carr_nom'
        ]);
        $carrera = Carrera::findOrFail($id);
        $carrera->update(['carr_nom' => $request->input('carr_nom_edit')]);
        return to_route('carreras.index');
    }

    public function destroy($id)
    {
        $carrera = Carrera::findOrFail($id);
        $carrera->delete();
        return to_route('carreras.index');
    }
}
