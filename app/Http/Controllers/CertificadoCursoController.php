<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCertificadoCursoRequest;
use App\Models\CertificadoCurso;
use App\Models\InscripcionCurso;
use App\Models\Visitas;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CertificadoCursoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:' . config('variables.rol_admin') . '|' . config('variables.rol_admin_inscrip'));
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

        $inscripciones = InscripcionCurso::where('inscrip_curs_estado', '=', 'true')->get();
        $certificados = CertificadoCurso::join('persona', 'certificado_curso.estudiante', '=', 'persona.per_id')
            ->where('persona.per_nom', 'ilike', '%' . $search . '%')
            ->orwhere('persona.per_appm', 'ilike', '%' . $search . '%')
            ->paginate(5);

        return view('content.pages.certificados.pages-certificado-curso', ['visitas' => $visitas, 'ruta' => $route, 'busqueda' => $search, 'certificados' => $certificados, 'inscripciones' => $inscripciones]);
    }


    public function create()
    {
        //
    }


    public function store(StoreCertificadoCursoRequest $request)
    {
        date_default_timezone_set("America/La_Paz");
        setlocale(LC_TIME, 'es_BO.UTF-8', 'esp');

        $id = $request->input('inscrip_curs_id');
        $descrip =  $request->input('cert_curs_descrip');

        $inscripcion = InscripcionCurso::find($id);


        $fecha = $request->input('cert_curs_fecha');
        if ($inscripcion) {
            if ($inscripcion->inscrip_curs_estado == false) {
                return redirect()->back()->withErrors(['err' => 'NO existe el registro ' . $id]);
            }
            $existeCertificado = CertificadoCurso::where([
                ['estudiante', '=', $inscripcion->persona->per_id],
                ['curso', '=', $inscripcion->curs->curs_id]
            ])->get();

            if (sizeof($existeCertificado) > 0) {
                return redirect()->back()->withErrors(['err' => 'El estudiante ya tiene un certificado de este curso']);
            }
            $certificado = CertificadoCurso::create([
                'cert_curs_descrip' => $descrip,
                'cert_curs_fecha' => $fecha,
                'estudiante' => $inscripcion->persona->per_id,
                'curso' => $inscripcion->curs->curs_id
            ]);

            return redirect()->route('certificados-curso.show', ['certificados_curso' => $certificado->cert_curs_id]);
        }
        return redirect()->back()->withErrors(['er' => 'El Id no existe o el estudiante no esta inscrito']);
    }


    public function show($id)
    {
        date_default_timezone_set("America/La_Paz");
        setlocale(LC_TIME, 'es_BO.UTF-8', 'esp');
        $certificado = CertificadoCurso::find($id);
        if ($certificado) {
            $path = request()->path();
            $basepath = preg_replace("/\/[0-9]+/", "/*", $path);
            $this->updateVisitCount($basepath);
            $visitas = Visitas::where('ruta', $basepath)->first();

            return view('content.pages.certificados.pages-certificados-cursos-view', ['certificado' => $certificado, 'visitas' => $visitas]);
        }
        return redirect()->back()->withErrors(['er' => 'No existe el id del certificado']);
    }

    public function edit($id)
    {
        $certificado = CertificadoCurso::find($id);
        if ($certificado) {
            $path = request()->path();
            $basepath = preg_replace('/\/\d+/', '/*', $path);
            $this->updateVisitCount($basepath);
            $visitas = Visitas::where('ruta', $basepath)->first();

            return view('content.pages.certificados.pages-certificado-curso-edit', ['certificado' => $certificado, 'visitas' => $visitas]);
        }
        return redirect()->back()->withErrors(['er' => 'El certificado no existe']);
    }

    public function update(StoreCertificadoCursoRequest $request, $id)
    {


        $certificado = CertificadoCurso::find($id);
        if ($certificado) {
            $certificado->update([
                'cert_curs_descrip' => $request->input('cert_curs_descrip'),
                'cert_curs_fecha' => $request->input('cert_curs_fecha')
            ]);
            return redirect()->action([CertificadoCursoController::class, 'index']);
        }
        return redirect()->back()->withErrors(['er' => 'El certificado no existe']);
    }

    public function destroy($id)
    {
        try {
            $certificado = CertificadoCurso::find($id);
            $certificado->delete();
            return to_route('certificados-curso.index');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['er' => 'Error al eliminar']);
        }
    }
}
