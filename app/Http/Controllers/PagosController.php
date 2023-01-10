<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlanPagoRequest;
use App\Models\InscripcionPrograma;
use App\Models\Pago;
use App\Models\PlanDePago;
use Exception;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class PagosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content.pages.pagos.pages-pagos');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($planPago)
    {
        $plan = PlanDePago::find($planPago);
        return view('content.pages.pagos.pages-pagos-registro', ['plan' => $plan]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->input('inscripcion_alumno');
        if (is_numeric($id)) {
            $inscripcion = InscripcionPrograma::find($id);
            if ($inscripcion == null) {
                return redirect()->back()->withErrors(['er' => 'EL nro de inscripcion no existe']);
            }

            $verPlan = PlanDePago::where('inscripcion', $inscripcion->inscrip_program_nro)->get();
            if (sizeof($verPlan) > 0) {
                return redirect()->back()->withErrors(['er' => 'La inscripcion ya esta pagada o ya tiene un plan de pagos']);
            }

            $plan  = PlanDePago::create([
                'plan_pago_descrip' => '',
                'plan_pago_pagtot' => $inscripcion->program->program_precio,
                'inscripcion' => $id
            ]);

            return view('content.pages.pagos.pages-pagos-registro', ['plan' => $plan]);
        } else {
            return redirect()->back()->withErrors(['er' => 'Error... el nro de inscripcion debe ser numerico']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plan = PlanDePago::find($id);
        if ($plan) {

            return view('content.pages.pagos.pagos-view', ['plan' => $plan]);
        }
        return redirect()->back()->withErrors(['er' => 'Ocurrio un error, El nro de pago no existe']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = PlanDePago::find($id);
        if ($plan) {
            return view('content.pages.pagos.pages-pagos-edit', ['plan' => $plan]);
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePlanPagoRequest $request, $id)
    {

        $tipo = $request->input('pago_tipo');

        $plan = PlanDePago::find($id);
        if ($plan) {

            $planDescrip = $request->input('plan_pago_descrip');
            $descripcion = ($planDescrip == null) ? "" : $planDescrip;
            $plan->update([
                'plan_pago_descrip' => $descripcion,
                'plan_pago_pagtot' => $request->input('plan_pago_pagtot'),
            ]);

            if ($tipo == 1) {
                $concepto = 'Pago al contado del programa ' . $plan->inscripcion_programa->program->program_nom;
                $pago = Pago::create([
                    'pago_concepto' => $concepto,
                    'pago_fecha_cobro' => now(),
                    'pago_monto' => $request->input('plan_pago_pagtot'),
                    'pago_estado' => true,
                    'plan_pago' => $id
                ]);
                $pago->pago_estado = true;
                $pago->save();
            }
            return view('content.pages.pagos.pagos-view', ['plan' => $plan]);
        }
        return redirect()->back()->withErrors(['er' => 'Ocurrio un error, El nro de pago no existe']);
    }

    public function updatePlan(StorePlanPagoRequest $request, $id)
    {

        $plan = PlanDePago::find($id);
        if ($plan) {

            $planDescrip = $request->input('plan_pago_descrip');
            $descripcion = ($planDescrip == null) ? "" : $planDescrip;
            $plan->update([
                'plan_pago_descrip' => $descripcion,
                'plan_pago_pagtot' => $request->input('plan_pago_pagtot'),

            ]);

            return view('content.pages.pagos.pagos-view', ['plan' => $plan]);
        }
        return redirect()->back()->withErrors(['er' => 'Ocurrio un error, El nro de pago no existe']);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        try {
            $plan = PlanDePago::find($id);
            $plan->delete();
            return to_route('pagos.index');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['er' => 'Ocurrio un error, verifique su conexion']);
        }
    }
}
