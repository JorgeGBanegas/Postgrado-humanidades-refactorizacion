<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDescuentosRequest;
use App\Models\Descuento;
use App\Models\Programa;
use App\Models\Visitas;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class DescuentosController extends Controller
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
        $descuentos = Descuento::join('programa', 'programa.program_id', 'descuento.program_id')
            ->where(function ($q) use ($search) {
                $q->where('programa.program_nom', 'ilike', '%' . $search . '%')
                    ->orwhere('descuento.desc_motivo', 'ilike', '%' . $search . '%')
                    ->orwhere('descuento.desc_descrip', 'ilike', '%' . $search . '%');
            })->orderBy('descuento.desc_id', 'DESC')->paginate(5);

        return view('content.pages.descuentos.pages-descuentos', ['descuentos' => $descuentos, 'visitas' => $visitas, 'ruta' => $route, 'busqueda' => $search]);
    }

    public function create()
    {
        $path = request()->path();
        $this->updateVisitCount($path);
        $visitas = Visitas::where('ruta', $path)->first();

        $programas = Programa::get();
        return view('content.pages.descuentos.pages-descuentos-registro', ['programas' => $programas, 'visitas' => $visitas]);
    }
    public function store(StoreDescuentosRequest $request)
    {

        Descuento::create($request->all());
        return to_route('descuentos.index');
    }
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $path = request()->path();
        $basepath = preg_replace("/\/[0-9]+/", "/*", $path);
        $this->updateVisitCount($basepath);
        $visitas = Visitas::where('ruta', $basepath)->first();

        $descuento = Descuento::find($id);
        $programas = Programa::get();
        return view('content.pages.descuentos.pages-descuentos-update', ['descuento' => $descuento, 'programas' => $programas, 'visitas' => $visitas]);
    }

    public function update(StoreDescuentosRequest $request, $id)
    {

        $descuento = Descuento::findOrFail($id);
        $descuento->update($request->all());

        return to_route('descuentos.index');
    }

    public function changeStatus($id)
    {
        $descuento = Descuento::findOrFail($id);
        $descuento->update([
            'desc_est' => !$descuento->desc_est
        ]);

        return to_route('descuentos.index');
    }

    public function destroy($id)
    {
        try {
            $curso = Descuento::findOrFail($id);
            $curso->delete();
            return to_route('descuentos.index');
        } catch (QueryException $e) {
            if ($e->getCode() == "23503") {
                return redirect()->back()->withErrors(['err' => 'No puedes eliminar el curso, hay registros que dependen de el']);
            }
            return redirect()->back()->withErrors(['err' => 'Error de conexion intente mas tarde']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['err' => $e->getMessage()]);
        }
    }
}
