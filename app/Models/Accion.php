<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Accion
 * 
 * @property int $acc_id
 * @property string|null $acc_nom
 * @property string|null $acc_param
 * @property string|null $acc_descrip
 * @property bool|null $acc_est
 * @property Carbon $acc_create
 * @property Carbon $acc_update
 * @property int $mod_id
 * 
 * @property Modulo $modulo
 *
 * @package App\Models
 */
class Accion extends Model
{
	protected $table = 'accion';
	protected $primaryKey = 'acc_id';
	public $timestamps = false;

	protected $casts = [
		'acc_est' => 'bool',
		'mod_id' => 'int'
	];

	protected $dates = [
		'acc_create',
		'acc_update'
	];

	protected $fillable = [
		'acc_nom',
		'acc_param',
		'acc_descrip',
		'acc_est',
		'acc_create',
		'acc_update',
		'mod_id'
	];

	public function modulo()
	{
		return $this->belongsTo(Modulo::class, 'mod_id');
	}
}
