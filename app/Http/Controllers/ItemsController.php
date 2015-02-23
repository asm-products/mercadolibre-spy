<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Analysis;
use App\Source;
use App\Item;
use Auth;

use Illuminate\Http\Request;

class ItemsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Analysis $analysis)
	{
		$items = Item::where('analysis_id', $analysis->id)->get();
		return view('items/index', compact('analysis', 'items', 'source'));
	}

	public function follow(Request $request)
	{

		foreach ($request->follow as $itemId=>$follow)
		{

			$item = Item::find($itemId);

			$item->following = $follow;
			$item->save();

		}

		return redirect('analysis');

	}

}
