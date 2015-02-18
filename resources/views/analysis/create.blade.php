@extends('app')

@section('content')

  <h1>New Analysis</h1>

  {!! Form::open(['url'=>'analysis']) !!}

    @include ('analysis.form', ['submitButton'=>'Create analysis'])

  {!! Form::close() !!}

  @include ('errors.list')

@stop
