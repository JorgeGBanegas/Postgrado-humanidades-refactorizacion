<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Programa
 * 
 * @property int $program_id
 * @property string $program_nom
 * @property float $program_precio
 * @property USER-DEFINED $program_modalidad
 * @property USER-DEFINED $program_tipo
 * 
 * @property Collection|Descuento[] $descuentos
 * @property Collection|ModuloPrograma[] $modulo_programas
 * @property Collection|GrupoPrograma[] $grupo_programas
 * @property Collection|Carrera[] $carreras
 * @property Collection|CertificadoPrograma[] $certificado_programas
 * @property Collection|InscripcionPrograma[] $inscripcion_programas
 *
 * @package App\Models
 */
class Programa extends Model
{
	protected $table = 'programa';
	protected $primaryKey = 'program_id';
	public $timestamps = false;

	protected $casts = [
		'program_precio' => 'float'
	];

	protected $fillable = [
		'program_nom',
		'program_precio',
		'program_modalidad',
		'program_tipo'
	];

	public function descuentos()
	{
		return $this->hasMany(Descuento::class, 'program_id');
	}

	public function modulo_programas()
	{
		return $this->hasMany(ModuloPrograma::class, 'programa');
	}

	public function grupo_programas()
	{
		return $this->hasMany(GrupoPrograma::class, 'programa');
	}

	public function carreras()
	{
		return $this->belongsToMany(Carrera::class, 'carrera_programa', 'programa', 'carrera')
			->withPivot('carr_program_id');
	}

	public function certificado_programas()
	{
		return $this->hasMany(CertificadoPrograma::class, 'programa');
	}

	public function inscripcion_programas()
	{
		return $this->hasMany(InscripcionPrograma::class, 'programa');
	}
}
