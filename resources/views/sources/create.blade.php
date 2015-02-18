@extends('app')

@section('content')

<ol class="breadcrumb">
  <li><a href="{{ url('/analysis') }}">analysis</a></li>
  <li><a href="{{ url('/analysis', [$analysis->id]) }}">{!! $analysis->name !!}</a></li>
  <li class="active">Add Source</li>
</ol>

<h1>Add Source to {{ $analysis->name }}</h1>

{!! Form::open(['method'=>'PUT', 'url'=>'analysis/'.$analysis->id.'/sources']) !!}

<div class="form-group">

  {!! Form::label('type', 'Type:') !!}
  {!! Form::select('type', ['query'=>'Query', 'category'=>'Category', 'seller'=>'Seller']) !!}

</div>

<div class="form-group">

  {!! Form::label('filters', 'Filters: ') !!}
  {!! Form::text('filters', null, ['class'=>'form-control']) !!}

</div>

<div class="form-group">

  {!! Form::submit('Create Source', ['class'=>'btn btn-primary form-control']) !!}

</div>

{!! Form::close() !!}

@if ($errors->any())

  <div class="alert alert-danger">

    <h4>Please correct these errors:</h4>
    <p>
    @foreach ($errors->all() as $error)
    {{ $error }}<br />
    @endforeach
  </p>
  </div>

@endif

@stop
