<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Translation
 * 
 * @property int $id
 * @property string $slug
 * @property string $nl
 * @property string $en
 *
 * @package App\Models
 */
class Translation extends Model
{
	protected $table = 'translations';
	public $timestamps = false;

	protected $fillable = [
		'slug',
		'nl',
		'en'
	];
}
