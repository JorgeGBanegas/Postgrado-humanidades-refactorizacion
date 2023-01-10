<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CertificadoCurso
 * 
 * @property int $cert_curs_id
 * @property string $cert_curs_descrip
 * @property Carbon $cert_curs_fecha
 * @property int $estudiante
 * @property int $curso
 * 
 * @property Persona $persona
 *
 * @package App\Models
 */
class CertificadoCurso extends Model
{
	protected $table = 'certificado_curso';
	protected $primaryKey = 'cert_curs_id';
	public $timestamps = false;

	protected $casts = [
		'estudiante' => 'int',
		'curso' => 'int'
	];

	protected $dates = [
		'cert_curs_fecha'
	];

	protected $fillable = [
		'cert_curs_descrip',
		'cert_curs_fecha',
		'estudiante',
		'curso'
	];

	public function persona()
	{
		return $this->belongsTo(Persona::class, 'estudiante');
	}

	public function curs()
	{
		return $this->belongsTo(Curso::class, 'curso');
	}
}
