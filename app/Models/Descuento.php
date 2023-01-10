<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Descuento
 * 
 * @property int $desc_id
 * @property string $desc_motivo
 * @property bool|null $desc_est
 * @property string|null $desc_descrip
 * @property int $desc_porce
 * @property int $program_id
 * 
 * @property Programa $programa
 *
 * @package App\Models
 */
class Descuento extends Model
{
	protected $table = 'descuento';
	protected $primaryKey = 'desc_id';
	public $timestamps = false;

	protected $casts = [
		'desc_est' => 'bool',
		'desc_porce' => 'int',
		'program_id' => 'int'
	];

	protected $fillable = [
		'desc_motivo',
		'desc_est',
		'desc_descrip',
		'desc_porce',
		'program_id'
	];

	public function programa()
	{
		return $this->belongsTo(Programa::class, 'program_id');
	}
}
