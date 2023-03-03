<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Carrera
 * 
 * @property int $carr_id
 * @property string $carr_nom
 * 
 * @property Collection|Programa[] $programas
 *
 * @package App\Models
 */
class Carrera extends Model
{
	protected $table = 'carrera';
	protected $primaryKey = 'carr_id';
	public $timestamps = false;

	protected $fillable = [
		'carr_nom'
	];

	public function programas()
	{
		return $this->hasMany(Programa::class, 'program_id');
	}
}
