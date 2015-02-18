<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Analysis;
use Auth;

class AnalysisController extends Controller {

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


}
