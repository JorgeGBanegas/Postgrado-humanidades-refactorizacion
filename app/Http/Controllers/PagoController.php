<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePagoRequest;
use App\Models\Pago;
use App\Models\PlanDePago;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($planPago, $tipo)
    {
        //return redirect()->action([PagosController::class, 'create'], ['planPago' => $planPago]);
        return view('content.pages.pagos.pages-add-pago', ['plan' => $planPago], ['tipo' => $tipo]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePagoRequest $request, $planPago)
    {

        $this->almacenarPago($request, $planPago);
        return redirect()->action([PagosController::class, 'create'], ['planPago' => $planPago]);
    }

    private function almacenarPago($request, $planPago)
    {
        $plan = PlanDePago::find($planPago);
        if (sizeof($plan->all()) == 0) {
            return redirect()->back()->withErrors(['er' => 'Error... El plan de pago no existe']);
        }

        $totalAPagar = $plan->plan_pago_pagtot;
        foreach ($plan->pagos as $pago) {
            $monto = $pago->pago_monto;
            $totalAPagar -= $monto;
        }

        if (($totalAPagar - $request->input('pago_monto')) < 0) {
            // return redirect()->action([PagosController::class, 'create'], ['planPago' => $planPago]);
            return redirect()->back()->withErrors(['er' => 'El monto sobrepasa el precio total']);
        }


        $fechaIngresada = strtotime($request->input('pago_fecha_cobro'));

        foreach ($plan->pagos as $pago) {
            $cobro = strtotime($pago->pago_fecha_cobro);
            if ($fechaIngresada <= $cobro) {
                return redirect()->back()->withErrors(['er' => 'No puede ingresar una fecha anterior a la fecha del ultimo pago']);
            }
        }



        $pago = Pago::create([
            'pago_concepto' => $request->input('pago_concepto'),
            'pago_fecha_cobro' => $request->input('pago_fecha_cobro'),
            'pago_monto' => $request->input('pago_monto'),
            'plan_pago' => $planPago
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePago(StorePagoRequest $request, $planPago)
    {
        $this->almacenarPago($request, $planPago);
        return redirect()->action([PagosController::class, 'edit'], ['pago' => $planPago]);
    }

    public function updateEstado($id)
    {
        $pago = Pago::find($id);
        if ($pago) {
            $pago->pago_estado = true;
            $pago->save();
            return redirect()->back();
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
}
