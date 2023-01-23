<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDescuentosRequest;
use App\Models\Descuento;
use App\Models\Programa;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class DescuentosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:' . config('variables.rol_admin') . '|' . config('variables.rol_admin_progr'));
    }

    public function index()
    {
        return view('content.pages.descuentos.pages-descuentos');
    }

    public function create()
    {
        $programas = Programa::get();
        return view('content.pages.descuentos.pages-descuentos-registro', ['programas' => $programas]);
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
        $descuento = Descuento::find($id);
        $programas = Programa::get();
        return view('content.pages.descuentos.pages-descuentos-update', ['descuento' => $descuento, 'programas' => $programas]);
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
