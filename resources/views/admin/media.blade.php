@extends('adminlte::page')

@section('content_header')
    <h1>Media Manager</h1>
@stop

@section('content')
<div id="media"></div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="{{asset('vendor/midia/midia.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/midia/dropzone.css')}}">
@stop

@section('js')

    <script src="{{asset('vendor/midia/dropzone.js')}}"></script>
    <script src="{{asset('vendor/midia/clipboard.js')}}"></script>
    <script src="{{asset('vendor/midia/midia.js')}}"></script>

    <script>
        $("#media").midia({
            inline: true,
            base_url: '{{url('')}}'
        });
    </script>
@stop