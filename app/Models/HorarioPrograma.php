<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class HorarioPrograma
 * 
 * @property int $hora_program_id
 * @property string $hora_program_dia
 * @property time without time zone $hora_program_hini
 * @property time without time zone $hora_program_hfin
 * @property int $grup_program
 * 
 * @property GrupoPrograma $grupo_programa
 *
 * @package App\Models
 */
class HorarioPrograma extends Model
{
	protected $table = 'horario_programa';
	protected $primaryKey = 'hora_program_id';
	public $timestamps = false;

	protected $casts = [
		'grup_program' => 'int'
	];

	protected $fillable = [
		'hora_program_dia',
		'hora_program_hini',
		'hora_program_hfin',
		'grup_program'
	];

	public function grupo_programa()
	{
		return $this->belongsTo(GrupoPrograma::class, 'grup_program');
	}
}
