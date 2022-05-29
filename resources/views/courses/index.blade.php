@extends('adminlte::page')

@section('title', 'Dersler')

@section('content_header')
    <h1>Dersler</h1>
@stop

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-header d-flex">
                <h3>Dersler</h3>
                <a href="" data-toggle="modal" data-target="#myModal" id="open" class="btn btn-success ml-auto">Yeni Ekle</a>
            </div>
            <div class="card-body">
                <table class="table table table-bordered table-hover dataTable dtr-inline" id="tablo">
                    <thead>
                    <tr>
                        <th scope="col">Ders ID</th>
                        <th scope="col">Ders Adı</th>
                        <th scope="col">Ders Kodu</th>
                        <th scope="col">Rolüm</th>
                        <th scope="col">Yayında mı ?</th>
                        <th scope="col">Başlama Tarihi</th>
                        <th scope="col">Oluşturulma Tarihi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($courses as $course)
                        <tr>
                            <th>{{$course->id}}</th>
                            <td><a class="nav-link" href="{{route('courses.spesific', ['id' => $course->id])}}">{{$course->name}}</a></td>
                            <td>{{$course->course_code}}</td>
                            <td>
                                @foreach ($course->enrollments as $enrollment)
                                    {{__($enrollment->type)}}
                                @endforeach
                            </td>
                            <td>{!! ($course->workflow_state != "unpublished") ? "<span class = 'text-success'> Evet </span>" : "<span class = 'text-danger'> Hayır </span>" !!}</td>
                            <td>{{$course->start_at}}</td>
                            <td>{{$course->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
    </div>
@stop
@section('plugins.Datatables', true)

