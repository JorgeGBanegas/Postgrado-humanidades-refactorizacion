<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GrupoCurso
 * 
 * @property int $grup_curs_id
 * @property string $grup_curs_cod
 * @property int $curso
 * 
 * @property Collection|InscripcionCurso[] $inscripcion_cursos
 * @property Collection|HorarioCurso[] $horario_cursos
 *
 * @package App\Models
 */
class GrupoCurso extends Model
{
	protected $table = 'grupo_curso';
	protected $primaryKey = 'grup_curs_id';
	public $timestamps = false;

	protected $casts = [
		'curso' => 'int'
	];

	protected $fillable = [
		'grup_curs_cod',
		'curso'
	];

	public function curso()
	{
		return $this->belongsTo(Curso::class, 'curso');
	}

	public function inscripcion_cursos()
	{
		return $this->hasMany(InscripcionCurso::class, 'grupo');
	}

	public function horario_cursos()
	{
		return $this->hasMany(HorarioCurso::class, 'grup_curs');
	}
}
