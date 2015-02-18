@extends('app')

@section('content')

  <ol class="breadcrumb">
    <li><a href="{{ url('/analysis') }}">analysis</a></li>
    <li class="active">{{ $analysis->name }}</li>
  </ol>

  <h1>{{ $analysis->name }}</h1>

  <p>{{ $analysis->status}}</p>

@stop
