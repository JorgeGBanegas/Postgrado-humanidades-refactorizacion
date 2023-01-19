<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModuloProgramaRequest;
use App\Models\Modulo;
use App\Models\ModuloPrograma;
use Illuminate\Http\Request;

class ModuloProgramaController extends Controller
{
    public function store(Request $request)
    {
        dd($request);
        ///ModuloPrograma::create($request->all());
        return back();
    }
}
