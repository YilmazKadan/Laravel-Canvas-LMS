@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{$account->name}}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col col-md-2">
            @include('menuLayouts.account')
        </div>

        <div class="col col-md-4">
            Yönetim paneline hoşgeldiniz.
        </div>
    </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
