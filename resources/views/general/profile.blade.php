@extends('adminlte::page')

@section('title', 'Profil')

@section('content_header')
    <h1>Profilim</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                             src="{{$profile->avatar_url}}"
                             alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">{{$profile->name}}</h3>

                    <p class="text-muted text-center">Hesap bilgilileri.</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Başlık:</b> <a class="float-right">{{$profile->title}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Giriş ID:</b> <a class="float-right">{{$profile->login_id}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Email:</b> <a class="float-right">{{$profile->primary_email}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Zaman Dilimi:</b> <a class="float-right">{{$profile->time_zone}}</a>
                        </li>
                    </ul>

                    <a href="" class="btn btn-primary btn-block"><b>Güncelle</b></a>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

@stop
@section('css')
@stop

@section('js')
@stop
