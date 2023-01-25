<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlanPagoRequest;
use App\Models\InscripcionPrograma;
use App\Models\Pago;
use App\Models\PlanDePago;
use App\Models\Visitas;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class PagosController extends Controller
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


    public function index()
    {
        $path = request()->path();
        $this->updateVisitCount($path);
        $visitas = Visitas::where('ruta', $path)->first();
        return view('content.pages.pagos.pages-pagos', ['visitas' => $visitas]);
    }


    public function create()
    {
        $path = request()->path();
        $this->updateVisitCount($path);
        $visitas = Visitas::where('ruta', $path)->first();

        $listaDeInscritos = InscripcionPrograma::where('inscrip_program_estado', true)->get();
        return view('content.pages.pagos.pages-pagos-registro', ['listaDeInscritos' => $listaDeInscritos, 'visitas' => $visitas]);
    }


    public function store(Request $request)
    {

        $inscripcion = InscripcionPrograma::where('inscrip_program_nro', $request->input('inscripcion_alumno'))->first();
        $verPlan = PlanDePago::where('inscripcion', $inscripcion->inscrip_program_nro)->exists();
        if ($verPlan) {
            return redirect()->back()->withErrors(['er' => 'La inscripcion ya esta pagada o ya tiene un plan de pagos']);
        }

        DB::beginTransaction();
        try {

            $plan = PlanDePago::create([
                'plan_pago_descrip' => $request->input('plan_pago_descrip'),
                'plan_pago_pagtot' => $request->input('pago_descuento'),
                'inscripcion' => $inscripcion->inscrip_program_nro
            ]);

            if ($request->input('tipo_pago') == 1) {
                //crea un plan de pago con un solo pago

                Pago::create([
                    'pago_concepto' => 'Pago al contado del programa: ' . " " . $inscripcion->program->program_nom,
                    'pago_fecha_cobro' => date('Y-m-d'),
                    'pago_monto' => $request->input('pago_descuento'),
                    'pago_estado' => true,
                    'plan_pago' => $plan->plan_pago_nro
                ]);
            } else {
                //crea un plan de pago con varios  pago
                $listaDePagos = json_decode($request->pagosList, true);
                $totalAPagar = 0;
                foreach ($listaDePagos as $pago) {
                    $concepto = $pago['pago_concepto'];
                    $fechaCobro = date('d-m-Y', strtotime($pago['pago_fecha_cobro']));
                    $monto = $pago['pago_monto'];
                    $totalAPagar += $monto;
                    Pago::create([
                        'pago_concepto' => $concepto,
                        'pago_fecha_cobro' => $fechaCobro,
                        'pago_monto' => $monto,
                        'plan_pago' => $plan->plan_pago_nro

                    ]);
                }

                if ($totalAPagar != $request->input('pago_descuento')) {
                    throw new Exception('La suma de los pagos debe ser igual que el total a pagar');
                }
            }

            DB::commit();
            return to_route('pagos.index');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['err' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $plan = PlanDePago::find($id);
        if ($plan) {
            $path = request()->path();
            $basepath = preg_replace("/\/[0-9]+/", "/*", $path);
            $this->updateVisitCount($basepath);
            $visitas = Visitas::where('ruta', $basepath)->first();

            return view('content.pages.pagos.pagos-view', ['plan' => $plan, 'visitas' => $visitas]);
        }
        return redirect()->back()->withErrors(['er' => 'Ocurrio un error, El nro de pago no existe']);
    }

    public function edit($id)
    {
        $plan = PlanDePago::find($id);
        if ($plan) {
            $path = request()->path();
            $basepath = preg_replace('/\/\d+/', '/*', $path);
            $this->updateVisitCount($basepath);
            $visitas = Visitas::where('ruta', $basepath)->first();
            return view('content.pages.pagos.pages-pagos-edit', ['plan' => $plan, 'visitas' => $visitas]);
        }
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'plan_pago_descrip'  => 'required | string',
            ]
        )->validate();


        $plan = PlanDePago::find($id);
        if ($plan) {

            $planDescrip = $request->input('plan_pago_descrip');
            $descripcion = ($planDescrip == null) ? "" : $planDescrip;
            $plan->update([
                'plan_pago_descrip' => $descripcion,

            ]);

            return to_route('pagos.index');
        }
        return redirect()->back()->withErrors(['er' => 'Ocurrio un error, El nro de pago no existe']);
    }
    public function destroy($id)
    {
        try {
            $plan = PlanDePago::findOrFail($id);
            $plan->delete();
            return to_route('pagos.index');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['er' => 'Ocurrio un error, el plan o el pago no existen']);
        }
    }
}
