<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Curso
 * 
 * @property int $curs_id
 * @property string $curs_nom
 * @property Carbon $curs_fini
 * @property float $curs_precio
 * @property USER-DEFINED $curs_modalidad
 * @property int $curs_duracion
 * 
 * @property Collection|InscripcionCurso[] $inscripcion_cursos
 * @property Collection|GrupoCurso[] $grupo_cursos
 * @property Collection|CertificadoCurso[] $certificado_cursos
 *
 * @package App\Models
 */
class Curso extends Model
{
	protected $table = 'curso';
	protected $primaryKey = 'curs_id';
	public $timestamps = false;

	protected $casts = [
		'curs_precio' => 'float',
		'curs_duracion' => 'int'
	];

	protected $dates = [
		'curs_fini'
	];

	protected $fillable = [
		'curs_nom',
		'curs_fini',
		'curs_precio',
		'curs_modalidad',
		'curs_duracion'
	];

	public function inscripcion_cursos()
	{
		return $this->hasMany(InscripcionCurso::class, 'curso');
	}

	public function grupo_cursos()
	{
		return $this->hasMany(GrupoCurso::class, 'curso');
	}

	public function certificado_cursos()
	{
		return $this->hasMany(CertificadoCurso::class, 'curso');
	}
}
