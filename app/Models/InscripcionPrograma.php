<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InscripcionPrograma
 * 
 * @property int $inscrip_program_nro
 * @property Carbon $inscrip_program_fecha
 * @property int $estudiante
 * @property int $programa
 * @property int $grupo
 * 
 * @property Persona $persona
 * @property GrupoPrograma $grupo_programa
 * @property Collection|PlanDePago[] $plan_de_pagos
 *
 * @package App\Models
 */
class InscripcionPrograma extends Model
{
	protected $table = 'inscripcion_programa';
	protected $primaryKey = 'inscrip_program_nro';
	public $timestamps = false;

	protected $casts = [
		'estudiante' => 'int',
		'programa' => 'int',
		'grupo' => 'int'
	];

	protected $dates = [];

	protected $fillable = [
		'inscrip_program_fecha',
		'estudiante',
		'programa',
		'grupo'
	];

	public function persona()
	{
		return $this->belongsTo(Persona::class, 'estudiante');
	}

	public function program()
	{
		return $this->belongsTo(Programa::class, 'programa');
	}

	public function grupo_programa()
	{
		return $this->belongsTo(GrupoPrograma::class, 'grupo');
	}

	public function plan_de_pagos()
	{
		return $this->hasMany(PlanDePago::class, 'inscripcion');
	}
}
