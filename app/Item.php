<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

	protected $dates = [
		'last_cron_run',
		'published_at',
		'finish_date'
	];

	protected $fillable = [
		'analysis_id',
		'source_id',
		'following',
		'meli_id',
		'finish_date',
		'title',
		'published_at',
		'seller_id',
		'price',
		'currency',
		'buying_mode',
		'category_id',
		'sold',
		'visits',
		'available_units',
		'publication_type',
		'last_cron_run',
		'url'
	];

	public function analysis()
	{
		return $this->belongsTo('App\Analysis');
	}

	public function source()
	{
		return $this->belongsTo('App\Source');
	}

}
