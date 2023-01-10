<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class HorarioCurso
 * 
 * @property int $hora_curs_id
 * @property string $hora_curs_dia
 * @property time without time zone $hora_curs_hini
 * @property time without time zone $hora_curs_hfin
 * @property int $grup_curs
 * 
 * @property GrupoCurso $grupo_curso
 *
 * @package App\Models
 */
class HorarioCurso extends Model
{
	protected $table = 'horario_curso';
	protected $primaryKey = 'hora_curs_id';
	public $timestamps = false;

	protected $casts = [
		'grup_curs' => 'int'
	];

	protected $fillable = [
		'hora_curs_dia',
		'hora_curs_hini',
		'hora_curs_hfin',
		'grup_curs'
	];

	public function grupo_curso()
	{
		return $this->belongsTo(GrupoCurso::class, 'grup_curs');
	}
}
