<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Source extends Model {

	protected $dates = [
		'last_cron_run'
	];

	protected $fillable = [
		'analysis_id',
		'type',
		'filters'
	];

	public function analysis()
	{
		return $this->belongsTo('App\Analysis');
	}

	public function items()
	{
		return $this->hasMany('App\Item');
	}

}
