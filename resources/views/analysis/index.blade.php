@extends('app')

@section('content')

  <h1>Analysis</h1>

  <table class="table table-striped">

    <thead>
      <tr>
        <th>Analysis</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>

    <tbody>
    @foreach ($all as $analysis)

      <tr>
        <td>
          <strong><a href="{{ url('analysis', [$analysis->id]) }}">{!! $analysis->name !!}</a></strong>
          <br /><small>{!! $analysis->site !!} &mdash; Created {{ $analysis->created_at->diffForHumans() }}</small>
        </td>

        <td>
          @if ($analysis->status == 'active')
          <span class="label label-success glyphicon glyphicon-ok" aria-hidden="true"> </span>
          @else
          <span class="label label-danger glyphicon glyphicon-remove" aria-hidden="true"> </span>
          @endif

        </td>

        <td>
          <a href="{{ url('analysis', [$analysis->id, 'edit']) }}" class="btn btn-primary btn-xs">Edit</a>
          <a href="{{ url('analysis/'.$analysis->id.'/sources') }}" class="btn btn-default btn-xs">{{ $analysis->sources()->count() }} sources</a>
          @if ($analysis->items()->where('following','')->count() > 0)
          <a href="{{ url('analysis/'.$analysis->id.'/items') }}" class="btn btn-default btn-xs"><span class="badge">{{ $analysis->items()->where('following','')->count() }}</span> new items</a>
          @endif
        </td>
      </tr>

    @endforeach
    </tbody>

    <tfooter>

      <tr>

        <td colspan="3" class="text-center"><a href="{{ url('analysis/create') }}" class="btn btn-primary">Create analysis</a></td>

      </tr>

    </tfooter>

  </table>

@stop
