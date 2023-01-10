<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CertificadoPrograma
 * 
 * @property int $cert_program_id
 * @property string $cert_program_descrip
 * @property Carbon $cert_program_fecha
 * @property int $estudiante
 * @property int $programa
 * 
 * @property Persona $persona
 *
 * @package App\Models
 */
class CertificadoPrograma extends Model
{
	protected $table = 'certificado_programa';
	protected $primaryKey = 'cert_program_id';
	public $timestamps = false;

	protected $casts = [
		'estudiante' => 'int',
		'programa' => 'int'
	];

	protected $dates = [
		'cert_program_fecha'
	];

	protected $fillable = [
		'cert_program_descrip',
		'cert_program_fecha',
		'estudiante',
		'programa'
	];

	public function persona()
	{
		return $this->belongsTo(Persona::class, 'estudiante');
	}

	public function program()
	{
		return $this->belongsTo(Programa::class, 'programa');
	}
}
