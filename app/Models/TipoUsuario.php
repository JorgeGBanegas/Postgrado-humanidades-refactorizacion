<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoUsuario
 * 
 * @property int $tipo_us_id
 * @property string $tipo_us_nombre
 * 
 * @property Collection|Persona[] $personas
 *
 * @package App\Models
 */
class TipoUsuario extends Model
{
	protected $table = 'tipo_usuario';
	protected $primaryKey = 'tipo_us_id';
	public $timestamps = false;

	protected $fillable = [
		'tipo_us_nombre'
	];

	public function personas()
	{
		return $this->hasMany(Persona::class, 'per_tipo');
	}
}
