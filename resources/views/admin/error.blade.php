@extends('adminlte::page')

@section('content_header')
    <h1>Uh-oh!</h1>
@stop

@section('content')
    <p>{{ $errorMsg }}</p>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

@stop