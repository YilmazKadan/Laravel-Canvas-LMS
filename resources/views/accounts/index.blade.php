@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Hesaplar</h1>
@stop

@section('content')
    <div class="row">
        <div class="col col-md-4">
            Yönettiğim Hesaplar
            <nav class="navbar navbar-light bg-light">
            <ul class="navbar-nav">
                @foreach($accounts as $account)
                    <li class="navbar-item"><a class="nav-link" href="{{route('accounts.spesific', ['id' => $account->id])}}">{{$account->name}}</a></li>
                @endforeach
            </ul>
            </nav>
        </div>
    </div>
    </div>
@stop

