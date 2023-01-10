<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GrupoPrograma
 * 
 * @property int $grup_program_id
 * @property string $grup_program_cod
 * @property string $grup_program_vers
 * @property string $grup_program_edic
 * @property Carbon $grup_program_fini
 * @property int $programa
 * 
 * @property Collection|HorarioPrograma[] $horario_programas
 * @property Collection|InscripcionPrograma[] $inscripcion_programas
 *
 * @package App\Models
 */
class GrupoPrograma extends Model
{
	protected $table = 'grupo_programa';
	protected $primaryKey = 'grup_program_id';
	public $timestamps = false;

	protected $casts = [
		'programa' => 'int'
	];

	protected $dates = [
		'grup_program_fini'
	];

	protected $fillable = [
		'grup_program_cod',
		'grup_program_vers',
		'grup_program_edic',
		'grup_program_fini',
		'programa'
	];

	public function programa()
	{
		return $this->belongsTo(Programa::class, 'programa');
	}

	public function horario_programas()
	{
		return $this->hasMany(HorarioPrograma::class, 'grup_program');
	}

	public function inscripcion_programas()
	{
		return $this->hasMany(InscripcionPrograma::class, 'grupo');
	}
}
