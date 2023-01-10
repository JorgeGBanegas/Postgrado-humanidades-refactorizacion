<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Grupo
 * 
 * @property int $grup_id
 * @property string $grup_nom
 * @property string $grup_descrip
 * @property bool $grup_est
 * @property Carbon $grup_create
 * @property Carbon $grup_update
 * 
 * @property Collection|Permiso[] $permisos
 * @property Collection|Modulo[] $modulos
 *
 * @package App\Models
 */
class Grupo extends Model
{
	protected $table = 'grupo';
	protected $primaryKey = 'grup_id';
	public $timestamps = false;

	protected $casts = [
		'grup_est' => 'bool'
	];

	protected $dates = [
		'grup_create',
		'grup_update'
	];

	protected $fillable = [
		'grup_nom',
		'grup_descrip',
		'grup_est',
		'grup_create',
		'grup_update'
	];

	public function permisos()
	{
		return $this->hasMany(Permiso::class, 'grup_id');
	}

	public function modulos()
	{
		return $this->belongsToMany(Modulo::class, 'grupo_modulo', 'grup_id', 'mod_id')
					->withPivot('grup_mod_id', 'mod_grup_fins', 'mod_grup_create', 'mod_grup_update');
	}
}
