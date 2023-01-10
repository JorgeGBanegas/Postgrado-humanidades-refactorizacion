<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Persona
 * 
 * @property int $per_id
 * @property int $per_ci
 * @property string $per_nom
 * @property string $per_appm
 * @property string $per_prof
 * @property string $per_telf
 * @property string $per_cel
 * @property string $per_email
 * @property Carbon $per_fnac
 * @property string $per_lnac
 * @property bool $per_est
 * @property Carbon $per_create
 * @property Carbon $per_update
 * @property int $per_tipo
 * 
 * @property TipoUsuario $tipo_usuario
 * @property Collection|InscripcionCurso[] $inscripcion_cursos
 * @property Collection|Permiso[] $permisos
 * @property Collection|ModuloPrograma[] $modulo_programas
 * @property Collection|CertificadoPrograma[] $certificado_programas
 * @property Collection|CertificadoCurso[] $certificado_cursos
 * @property Collection|InscripcionPrograma[] $inscripcion_programas
 *
 * @package App\Models
 */
class Persona extends Model
{
	protected $table = 'persona';
	protected $primaryKey = 'per_id';
	public $timestamps = false;

	protected $casts = [
		'per_ci' => 'int',
		'per_est' => 'bool',
		'per_tipo' => 'int'
	];

	protected $dates = [
		'per_create',
		'per_update'
	];

	protected $fillable = [
		'per_ci',
		'per_nom',
		'per_appm',
		'per_prof',
		'per_telf',
		'per_cel',
		'per_email',
		'per_fnac',
		'per_lnac',
		'per_est',
		'per_create',
		'per_update',
		'per_tipo'
	];

	public function tipo_usuario()
	{
		return $this->belongsTo(TipoUsuario::class, 'per_tipo');
	}

	public function inscripcion_cursos()
	{
		return $this->hasMany(InscripcionCurso::class, 'estudiante');
	}

	public function permisos()
	{
		return $this->hasMany(Permiso::class, 'per_id');
	}

	public function modulo_programas()
	{
		return $this->hasMany(ModuloPrograma::class, 'docente');
	}

	public function certificado_programas()
	{
		return $this->hasMany(CertificadoPrograma::class, 'estudiante');
	}

	public function certificado_cursos()
	{
		return $this->hasMany(CertificadoCurso::class, 'estudiante');
	}

	public function inscripcion_programas()
	{
		return $this->hasMany(InscripcionPrograma::class, 'estudiante');
	}
}
