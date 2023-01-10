<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CarreraPrograma
 * 
 * @property int $carr_program_id
 * @property int $carrera
 * @property int $programa
 * 
 *
 * @package App\Models
 */
class CarreraPrograma extends Model
{
	protected $table = 'carrera_programa';
	protected $primaryKey = 'carr_program_id';
	public $timestamps = false;

	protected $casts = [
		'carrera' => 'int',
		'programa' => 'int'
	];

	protected $fillable = [
		'carrera',
		'programa'
	];

	public function carrera()
	{
		return $this->belongsTo(Carrera::class, 'carrera');
	}

	public function programa()
	{
		return $this->belongsTo(Programa::class, 'programa');
	}
}
