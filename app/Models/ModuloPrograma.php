<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ModuloPrograma
 * 
 * @property int $mod_program_id
 * @property int $mod_program_nro
 * @property string $mod_program_nom
 * @property Carbon $mod_program_fini
 * @property Carbon $mod_program_ffin
 * @property int $docente
 * @property int $programa
 * 
 * @property Persona $persona
 *
 * @package App\Models
 */
class ModuloPrograma extends Model
{
	protected $table = 'modulo_programa';
	protected $primaryKey = 'mod_program_id';
	public $timestamps = false;

	protected $casts = [
		'mod_program_nro' => 'int',
		'docente' => 'int',
		'programa' => 'int'
	];

	protected $dates = [
		'mod_program_fini',
		'mod_program_ffin'
	];

	protected $fillable = [
		'mod_program_nro',
		'mod_program_nom',
		'mod_program_fini',
		'mod_program_ffin',
		'docente',
		'programa'
	];

	public function persona()
	{
		return $this->belongsTo(Persona::class, 'docente');
	}

	public function programa()
	{
		return $this->belongsTo(Programa::class, 'programa');
	}
}
