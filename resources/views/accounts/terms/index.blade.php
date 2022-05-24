@extends('adminlte::page')

@section('title', 'Dönemler')

@section('content_header')
    <h1>Dönemler</h1>
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
            <div class="card-header d-flex">
                <h3>Dönemler</h3>
                <a href="" class="btn btn-success ml-auto">Yeni Ekle</a>
            </div>
            <div class="card-body">
                <table class="table table table-bordered table-hover dataTable dtr-inline" id="tablo">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Adı</th>
                        <th scope="col">Başlama Tarihi</th>
                        <th scope="col">Bitiş Tarihi</th>
                        <th scope="col">İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($donemler as $donem)
                        <tr>
                            <th>{{$donem->id}}</th>
                            <td>{{$donem->name}}</td>
                            <td>{{$donem->start_at}}</td>
                            <td>{{$donem->end_at}}</td>
                            <td>
                                <a href="" class="btn btn-primary">Güncelle</a>
                                <a href="" class="btn btn-danger">Sil</a>
                            </td>
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
