@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col col-md-4">
            Yönettiğim Hesaplar

            <ul>
                @foreach($accounts as $account)
                    <li><a href="{{route('accounts.spesific', ['id' => $account->id])}}">{{$account->name}}</a></li>
                @endforeach
            </ul>
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
