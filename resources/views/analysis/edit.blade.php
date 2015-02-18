@extends('app')

@section('content')

  <ol class="breadcrumb">
    <li><a href="{{ url('/analysis') }}">analysis</a></li>
    <li class="active">Edit {{ $analysis->name }}</li>
  </ol>

  <h1>Edit {!! $analysis->name !!}</h1>

  {!! Form::model($analysis, ['method'=>'PATCH', 'url'=>'analysis/'.$analysis->id]) !!}

    @include ('analysis.form', ['submitButton'=>'Update analysis'])

  {!! Form::close() !!}

  @include ('errors.list')

@stop
