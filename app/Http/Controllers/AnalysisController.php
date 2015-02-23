<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Analysis;
use Auth;

class AnalysisController extends Controller {

	protected $sales;
	protected $revenue;
	protected $sellers;
	protected $publication_type;
	protected $buying_mode;

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$all = Analysis::all();
		return view('analysis.index', compact('all'));
	}

	public function show(Analysis $analysis)
	{

		$this->getStats($analysis);
		dd($this);
		return view('analysis.show', compact('analysis'));

	}

	public function create()
	{
		return view('analysis.create');
	}

	public function store(Requests\AnalysisRequest $request)
	{
		$analysis = new Analysis($request->all());
		Auth::user()->analysis()->save($analysis);

		return redirect('analysis');
	}

	public function edit(Analysis $analysis)
	{
		return view('analysis.edit', compact('analysis'));
	}

	public function update(Analysis $analysis, Requests\AnalysisRequest $request)
	{
		$analysis->update($request->all());

		return redirect('analysis');
	}

	public function destroy(Analysis $analysis)
	{
		$analysis::delete($id);

		return redirect('analysis');
	}

	protected function getStats($analysis)
	{

		$this->sellers = [];
		$this->publication_type = [];
		$this->buying_mode = [];

		foreach ($analysis->following as $item)
		{
			$this->sales += $item->sold;

			$this->revenue += ($item->price * $item->sold);

			if ( isset ($this->sellers[$item->seller_id]))
			{
				$this->sellers[$item->seller_id]['sales'] = $this->sellers[$item->seller_id]['sales'] + $item->sold;
				$this->sellers[$item->seller_id]['revenue'] = $this->sellers[$item->seller_id]['revenue'] + ($item->price * $item->sold);
			}
			else
			{
				$this->sellers[$item->seller_id] = [
					'sales'		=> $item->sold,
					'revenue'	=> ($item->price * $item->sold)
				];
			}

			if ( isset ($this->publication_type[$item->publication_type]))
			{
				$this->publication_type[$item->publication_type] = $this->publication_type[$item->publication_type] + $item->sold;
			}
			else
			{
				$this->publication_type[$item->publication_type] = $item->sold;
			}

			if ( isset ($this->buying_mode[$item->buying_mode]))
			{
				$this->buying_mode[$item->buying_mode] = $this->buying_mode[$item->buying_mode] + $item->sold;
			}
			else
			{
				$this->buying_mode[$item->buying_mode] = $item->sold;
			}
		}

		return true;
	}

}
