<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PlanDePago
 * 
 * @property int $plan_pago_nro
 * @property string $plan_pago_descrip
 * @property float $plan_pago_pagtot
 * @property int $inscripcion
 * 
 * @property InscripcionPrograma $inscripcion_programa
 * @property Collection|Pago[] $pagos
 *
 * @package App\Models
 */
class PlanDePago extends Model
{
	protected $table = 'plan_de_pago';
	protected $primaryKey = 'plan_pago_nro';
	public $timestamps = false;

	protected $casts = [
		'plan_pago_pagtot' => 'float',
		'inscripcion' => 'int'
	];

	protected $fillable = [
		'plan_pago_descrip',
		'plan_pago_pagtot',
		'inscripcion'
	];

	public function inscripcion_programa()
	{
		return $this->belongsTo(InscripcionPrograma::class, 'inscripcion');
	}

	public function pagos()
	{
		return $this->hasMany(Pago::class, 'plan_pago');
	}
}
