<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Analysis extends Model {

	protected $table = 'analysis';

	protected $fillable = [
		'name',
		'status',
		'site'
	];

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function sources()
	{
		return $this->hasMany('App\Source');
	}

	public function items()
	{
		return $this->hasMany('App\Item');
	}

}
