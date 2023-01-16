<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgramaRequest;
use App\Models\Programa;
use Illuminate\Http\Request;

class ProgramaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:' . config('variables.rol_admin') . '|' . config('variables.rol_admin_progr'));
    }

    public function index()
    {
        return view('content.pages.programas.pages-programas');
    }

    public function create()
    {
        return view('content.pages.programas.pages-programas-registros');
    }


    public function store(StoreProgramaRequest $request)
    {
        Programa::create($request->all());
        return to_route('programas.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
