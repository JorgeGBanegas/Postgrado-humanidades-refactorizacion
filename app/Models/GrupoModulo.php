<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GrupoModulo
 * 
 * @property int $grup_mod_id
 * @property Carbon $mod_grup_fins
 * @property Carbon $mod_grup_create
 * @property Carbon $mod_grup_update
 * @property int $grup_id
 * @property int $mod_id
 * 
 * @property Grupo $grupo
 * @property Modulo $modulo
 *
 * @package App\Models
 */
class GrupoModulo extends Model
{
	protected $table = 'grupo_modulo';
	protected $primaryKey = 'grup_mod_id';
	public $timestamps = false;

	protected $casts = [
		'grup_id' => 'int',
		'mod_id' => 'int'
	];

	protected $dates = [
		'mod_grup_fins',
		'mod_grup_create',
		'mod_grup_update'
	];

	protected $fillable = [
		'mod_grup_fins',
		'mod_grup_create',
		'mod_grup_update',
		'grup_id',
		'mod_id'
	];

	public function grupo()
	{
		return $this->belongsTo(Grupo::class, 'grup_id');
	}

	public function modulo()
	{
		return $this->belongsTo(Modulo::class, 'mod_id');
	}
}
