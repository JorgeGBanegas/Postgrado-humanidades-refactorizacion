<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCertificadoProgramaRequest;
use App\Models\CertificadoPrograma;
use App\Models\InscripcionPrograma;
use Exception;
use Illuminate\Http\Request;

class CertificadoProgramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content.pages.certificados.pages-certificados');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCertificadoProgramaRequest $request)
    {
        $id = $request->input('inscrip_program_nro');
        $descrip =  $request->input('cert_program_descrip');
        $inscripcion = InscripcionPrograma::find($id);
        $fecha = $request->input('cert_program_fecha');


        if ($inscripcion) {
            if ($inscripcion->inscrip_program_estado == false) {
                return redirect()->back()->withErrors(['err' => 'NO existe el registro ' . $id]);
            }

            $existeCertificado = CertificadoPrograma::where([
                ['estudiante', '=', $inscripcion->persona->per_id],
                ['programa', '=', $inscripcion->program->program_id]
            ])->get();

            if (sizeof($existeCertificado) > 0) {
                return redirect()->back()->withErrors(['err' => 'El estudiante ya tiene un certificado de este curso']);
            }
            $certificado = CertificadoPrograma::create([
                'cert_program_descrip' => $descrip,
                'cert_program_fecha' => $fecha,
                'estudiante' => $inscripcion->persona->per_id,
                'programa' => $inscripcion->program->program_id
            ]);

            return view('content.pages.certificados.pages-certificados-view', ['certificado' => $certificado]);
        }
        return redirect()->back()->withErrors(['err' => 'El Id no existe o el estudiante no esta inscrito']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        date_default_timezone_set("America/La_Paz");
        setlocale(LC_TIME, 'es_BO.UTF-8', 'esp');
        $certificado = CertificadoPrograma::find($id);
        if ($certificado) {
            return view('content.pages.certificados.pages-certificados-view', ['certificado' => $certificado]);
        }
        return redirect()->back()->withErrors(['er' => 'No existe el id del certificado']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $certificado = CertificadoPrograma::find($id);
        if ($certificado) {
            return view('content.pages.certificados.pages-certificado-edit', ['certificado' => $certificado]);
        }
        return redirect()->back()->withErrors(['er' => 'El certificado no existe']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCertificadoProgramaRequest $request, $id)
    {
        $certificado = CertificadoPrograma::find($id);
        if ($certificado) {
            $certificado->update([
                'cert_program_descrip' => $request->input('cert_program_descrip'),
                'cert_program_fecha' => $request->input('cert_program_fecha')
            ]);
            return redirect()->action([CertificadoProgramaController::class, 'index']);
        }
        return redirect()->back()->withErrors(['er' => 'El certificado no existe']);
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
            $certificado = CertificadoPrograma::find($id);
            $certificado->delete();
            return to_route('certificados-programa.index');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['er' => 'Error al eliminar']);
        }
    }
}
