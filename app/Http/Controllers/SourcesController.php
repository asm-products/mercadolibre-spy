<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Analysis;
use App\Source;
use App\Item;
use Auth;

use Illuminate\Http\Request;

class SourcesController extends Controller {

	protected $baseUrl = 'https://api.mercadolibre.com/sites/{site}/search?q={query}&offset={offset}';

	public function __construct()
	{

		$this->middleware('auth');

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($analysis_id)
	{

		$sources = Source::where(['analysis_id'=>$analysis_id])->get();
		return $sources;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($analysis_id)
	{

		$analysis = Analysis::find($analysis_id);
		return view('sources.create', compact('analysis'));

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($id, Requests\SourceRequest $request)
	{
		$source = new Source($request->all());
		$source->analysis_id = $id;
		$source->save();

		return redirect('analysis');

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function parse()
	{

		// Get all sources
		$sources = Source::all();

		foreach ($sources as $source) {

			$this->parseMeli($source);

			$source->last_cron_run = \Carbon\Carbon::now();
			$source->save();

		}

		return true;
		
	}

	private function parseMeli($source, $offset=0)
	{

		// Init $url
		$url = '';

		if ($source->type=='query')
		{

			$keysToReplace = [
				'{site}',
				'{query}',
				'{offset}'
			];

			$valuesToReplace = [
				$source->analysis()->first()->site,
				urlencode($source->filters),
				$offset
			];

			$url = str_replace($keysToReplace, $valuesToReplace, $this->baseUrl);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSLVERSION, 3); // This is because of homestead -> https://laracasts.com/index.php/discuss/channels/general-discussion/curl-call-504ing-in-homestead
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			curl_close($ch);

			$response = json_decode($output);

			$items = $response->results;

			foreach ($items as $itemMeli)
			{

				$item = Item::where(['meli_id'=>$itemMeli->id, 'analysis_id'=>$source->analysis()->first()->id])->first();

				// Lookup for item, if exists, update it

				if ( ! is_null($item))
				{
					$item->title 						= $itemMeli->title;
					$item->price 						= $itemMeli->price;
					$item->category_id 			= $itemMeli->category_id;
					$item->sold 						= $itemMeli->sold_quantity;
					$item->available_units 	= $itemMeli->available_quantity;
					$item->publication_type = $itemMeli->listing_type_id;
					$item->last_cron_run 		= \Carbon\Carbon::now();

				}
					else
				{

					$item = new Item;

					$item->analysis_id			= $source->analysis()->first()->id;
					$item->source_id 				= $source->id;
					$item->meli_id					= $itemMeli->id;
					$item->finish_date			= strtotime($itemMeli->stop_time);
					$item->title						= $itemMeli->title;
					$item->seller_id				= $itemMeli->seller->id;
					$item->price						= $itemMeli->price;
					$item->currency					= $itemMeli->currency_id;
					$item->buying_mode			= $itemMeli->buying_mode;
					$item->category_id			= $itemMeli->category_id;
					$item->sold							= $itemMeli->sold_quantity;
					$item->available_units	= $itemMeli->available_quantity;
					$item->publication_type	= $itemMeli->listing_type_id;
					$item->last_cron_run		= \Carbon\Carbon::now();
					$item->url 							= $itemMeli->permalink;

				}

				$item->save();

			}

			// handle pagination =
			if ($response->paging->total > $response->paging->limit+$response->paging->offset)
			{
				$this->parseMeli($source, $response->paging->limit+$response->paging->offset);
			}

		}

		return true;

	}

}
