@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="container-fluid">

    </div>
    <div class="row">
        <div class="col col-md-2">
            @include('menuLayouts.account')
        </div>

        <div class="col col-md-10">
        <div class="card">
            <div class="card-body">
                <table class="table table table-bordered table-hover dataTable dtr-inline" id="tablo">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Login ID</th>
                        <th scope="col">Oluşturulma Tarihi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th>{{$user->id}}</th>
                            <td><a href=""></a>{{$user->name}}</td>
                            <td><a href=""></a>{{$user->login_id}}</td>
                            <td><a href=""></a>{{$user->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            </div>
        </div>
    </div>
    </div>
@stop
@section('plugins.Datatables', true)
@section('css')
@stop

@section('js')
    <script>
        $(document).ready(function () {
            $('#tablo').DataTable();
        });
    </script>
@stop
