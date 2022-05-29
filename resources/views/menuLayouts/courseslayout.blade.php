@section('plugins.Datatables', true)
@section('plugins.toastr', true)
@section('plugins.Select2',true)

@extends('adminlte::page')

@section('title', $course->name)

@section('content_header')
    <h1>{{$course->name}}</h1>
@stop

@section('content')
    <div class="row">
        @include("menuLayouts.messages")
    </div>
    <div class="row">
        <div class="col col-md-2">
            @include('menuLayouts.courses')
        </div>

        <div class="col-md-10">
            @yield("layout_content")
        </div>
    </div>
@stop
@section('css')
@stop

@section('js')

@stop
