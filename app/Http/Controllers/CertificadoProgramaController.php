<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCertificadoProgramaRequest;
use App\Models\CertificadoPrograma;
use App\Models\InscripcionPrograma;
use App\Models\Visitas;
use Exception;
use Illuminate\Http\Request;

class CertificadoProgramaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:' . config('variables.rol_admin') . '|' . config('variables.rol_admin_inscrip'));
    }

    public function index()
    {
        $path = request()->path();
        $this->updateVisitCount($path);
        $visitas = Visitas::where('ruta', $path)->first();

        return view('content.pages.certificados.pages-certificados', ['visitas' => $visitas]);
    }

    public function updateVisitCount($path)
    {
        $visit = Visitas::firstOrNew(['ruta' => $path]);
        $visit->increment('contador');
        $visit->save();
    }

    public function create()
    {
        //
    }

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

            return redirect()->route('certificados-programa.show', ['certificados_programa' => $certificado->cert_program_id]);            //            return view('content.pages.certificados.pages-certificados-view', ['certificado' => $certificado]);
        }
        return redirect()->back()->withErrors(['err' => 'El Id no existe o el estudiante no esta inscrito']);
    }

    public function show($id)
    {
        date_default_timezone_set("America/La_Paz");
        setlocale(LC_TIME, 'es_BO.UTF-8', 'esp');
        $certificado = CertificadoPrograma::find($id);
        if ($certificado) {
            $path = request()->path();
            $basepath = preg_replace("/\/[0-9]+/", "/*", $path);
            $this->updateVisitCount($basepath);
            $visitas = Visitas::where('ruta', $basepath)->first();

            return view('content.pages.certificados.pages-certificados-view', ['certificado' => $certificado, 'visitas' => $visitas]);
        }
        return redirect()->back()->withErrors(['er' => 'No existe el id del certificado']);
    }

    public function edit($id)
    {
        $certificado = CertificadoPrograma::find($id);
        if ($certificado) {
            $path = request()->path();
            $basepath = preg_replace('/\/\d+/', '/*', $path);
            $this->updateVisitCount($basepath);
            $visitas = Visitas::where('ruta', $basepath)->first();

            return view('content.pages.certificados.pages-certificado-edit', ['certificado' => $certificado, 'visitas' => $visitas]);
        }
        return redirect()->back()->withErrors(['er' => 'El certificado no existe']);
    }

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
