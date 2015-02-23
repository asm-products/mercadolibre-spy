@extends('app')

@section('content')

<ol class="breadcrumb">
  <li><a href="{{ url('/analysis') }}">analysis</a></li>
  <li><a href="{{ url('/analysis', [$analysis->id]) }}">{!! $analysis->name !!}</a></li>
  <li class="active">Review new Items</li>
</ol>

<h1>Review New Items</h1>


{!! Form::open(['url'=>'items']) !!}
  <table class="table table-striped">

    <thead>
      <tr>
        <th>Name</th>
        <th>Price</th>
        <th>Follow</th>
      </tr>
    </thead>

    <tbody>
    @foreach ($items as $item)

      <tr>
        <td><strong><a href="{{ $item->url }}" target="_blank">{{ $item->title }}</a></strong></td>
        <td>{{ number_format($item->price, 2, '.', ',') }} {{ $item->currency }}</td>
        <td>
          <label>
            @if ($item->following=='yes' || ! $item->following)
            {!! Form::radio('follow['.$item->id.']', 'yes', ['checked'=>'checked']) !!}
            @else
            {!! Form::radio('follow['.$item->id.']', 'yes') !!}
            @endif
          Yes
          </label>
          <label>
            @if ($item->following=='no')
            {!! Form::radio('follow['.$item->id.']', 'no', ['checked'=>'checked']) !!}
            @else
            {!! Form::radio('follow['.$item->id.']', 'no') !!}
            @endif
            No
          </label>
        </td>
      </tr>

    @endforeach
    </tbody>

    <tfooter>

      <tr>

        <td colspan="3" class="text-center">
          {!! Form::submit('Submit', ['class'=>'btn btn-primary form-control']) !!}
        </td>

      </tr>

    </tfooter>

  </table>

  {!! Form::close() !!}

@stop
