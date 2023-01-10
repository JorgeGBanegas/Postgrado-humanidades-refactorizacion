<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pago
 * 
 * @property int $pago_nro
 * @property string $pago_concepto
 * @property Carbon $pago_fecha_cobro
 * @property float $pago_monto
 * @property bool|null $pago_estado
 * @property int $plan_pago
 * 
 * @property PlanDePago $plan_de_pago
 *
 * @package App\Models
 */
class Pago extends Model
{
	protected $table = 'pago';
	protected $primaryKey = 'pago_nro';
	public $timestamps = false;

	protected $casts = [
		'pago_monto' => 'float',
		'pago_estado' => 'bool',
		'plan_pago' => 'int'
	];

	protected $dates = [];

	protected $fillable = [
		'pago_concepto',
		'pago_fecha_cobro',
		'pago_monto',
		'plan_pago'
	];

	public function plan_de_pago()
	{
		return $this->belongsTo(PlanDePago::class, 'plan_pago');
	}
}
