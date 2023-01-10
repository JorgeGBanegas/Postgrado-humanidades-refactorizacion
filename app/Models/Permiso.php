<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Permiso
 * 
 * @property int $perm_id
 * @property string $perm_pass
 * @property Carbon $perm_fini
 * @property Carbon $perm_ffin
 * @property bool $perm_est
 * @property Carbon $perm_create
 * @property Carbon $perm_update
 * @property int $per_id
 * @property int $grup_id
 * 
 * @property Persona $persona
 * @property Grupo $grupo
 *
 * @package App\Models
 */
class Permiso extends Model
{
	protected $table = 'permiso';
	protected $primaryKey = 'perm_id';
	public $timestamps = false;

	protected $casts = [
		'perm_est' => 'bool',
		'per_id' => 'int',
		'grup_id' => 'int'
	];

	protected $dates = [
		'perm_fini',
		'perm_ffin',
		'perm_create',
		'perm_update'
	];

	protected $fillable = [
		'perm_pass',
		'perm_fini',
		'perm_ffin',
		'perm_est',
		'perm_create',
		'perm_update',
		'per_id',
		'grup_id'
	];

	public function persona()
	{
		return $this->belongsTo(Persona::class, 'per_id');
	}

	public function grupo()
	{
		return $this->belongsTo(Grupo::class, 'grup_id');
	}
}
