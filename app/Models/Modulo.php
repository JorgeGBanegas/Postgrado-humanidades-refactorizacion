<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Modulo
 * 
 * @property int $mod_id
 * @property string $mod_nom
 * @property string $mod_descrip
 * @property int $mod_nivel
 * @property bool|null $mod_est
 * @property Carbon $mod_create
 * @property Carbon $mod_update
 * 
 * @property Collection|Grupo[] $grupos
 * @property Collection|Accion[] $accions
 *
 * @package App\Models
 */
class Modulo extends Model
{
	protected $table = 'modulo';
	protected $primaryKey = 'mod_id';
	public $timestamps = false;

	protected $casts = [
		'mod_nivel' => 'int',
		'mod_est' => 'bool'
	];

	protected $dates = [
		'mod_create',
		'mod_update'
	];

	protected $fillable = [
		'mod_nom',
		'mod_descrip',
		'mod_nivel',
		'mod_est',
		'mod_create',
		'mod_update'
	];

	public function grupos()
	{
		return $this->belongsToMany(Grupo::class, 'grupo_modulo', 'mod_id', 'grup_id')
					->withPivot('grup_mod_id', 'mod_grup_fins', 'mod_grup_create', 'mod_grup_update');
	}

	public function accions()
	{
		return $this->hasMany(Accion::class, 'mod_id');
	}
}
