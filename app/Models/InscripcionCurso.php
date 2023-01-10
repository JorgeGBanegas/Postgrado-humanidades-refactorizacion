<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InscripcionCurso
 * 
 * @property int $inscrip_curs_id
 * @property Carbon $inscrip_curs_fecha
 * @property int $estudiante
 * @property int $curso
 * @property int $grupo
 * 
 * @property Persona $persona
 * @property GrupoCurso $grupo_curso
 *
 * @package App\Models
 */
class InscripcionCurso extends Model
{
	protected $table = 'inscripcion_curso';
	protected $primaryKey = 'inscrip_curs_id';
	public $timestamps = false;

	protected $casts = [
		'estudiante' => 'int',
		'curso' => 'int',
		'grupo' => 'int'
	];

	protected $dates = [];

	protected $fillable = [
		'inscrip_curs_fecha',
		'estudiante',
		'curso',
		'grupo'
	];

	public function persona()
	{
		return $this->belongsTo(Persona::class, 'estudiante');
	}

	public function curs()
	{
		return $this->belongsTo(Curso::class, 'curso');
	}

	public function grupo_curso()
	{
		return $this->belongsTo(GrupoCurso::class, 'grupo');
	}
}
