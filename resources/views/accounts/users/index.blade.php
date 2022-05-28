@extends('adminlte::page')


@section('plugins.toastr', true)
@section('title', 'Kullanıcılar')

@section('content_header')
    <h1>Kullanıcılar</h1>
@stop

@section('content')
    <!-- Trigger the modal with a button -->
    <form method="post" action="{{route('accounts.users.store',["id" => request()->route()->id])}}" id="form">
    @csrf
    <!-- Modal -->
        <div class="modal" tabindex="-1" role="dialog" id="myModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="alert alert-danger" style="display:none"></div>
                    <div class="modal-header">

                        <h5 class="modal-title">Yeni User Ekle</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label for="name">Tam ad</label>
                                <input type="text" class="form-control"  name="name" id="name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label for="name">Görünen Ad</label>
                                <input type="text" class="form-control"  name="short_name" id="name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label for="name">Tam ad</label>
                                <input type="text" class="form-control"  name="sortable_name" id="name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label for="name">Oturum Açma ID</label>
                                <input type="text" class="form-control"  name="unique_id" id="name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label for="name">E-posta</label>
                                <input type="email" class="form-control"  name="email" id="name">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                        <button  class="btn btn-success" id="ajaxSubmit">Kayıt Et</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col col-md-2">
            @include('menuLayouts.account')
        </div>

        <div class="col col-md-10">
        <div class="card">
            <div class="card-header d-flex">
                <h3>Kişiler</h3>
                <a href="#" data-toggle = "modal" data-target="#myModal" class="btn btn-success ml-auto">Yeni Ekle</a>
            </div>
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
        //    Ajax işlemleri
            jQuery('#ajaxSubmit').click(function(e){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                jQuery.ajax({
                    url: $('#form').attr("action"),
                    method: 'post',
                    data: $("#form").serialize(),
                    success: function(result){
                        jQuery('.alert-danger').empty();
                        if(result.errors)
                        {
                            jQuery('.alert-danger').html('');
                            jQuery.each(result.errors, function(key, value){
                                jQuery('.alert-danger').show();
                                jQuery('.alert-danger').append('<li>'+value+'</li>');
                            });
                        }
                        else if (result.apierrors){
                            jQuery('.alert-danger').show();
                            jQuery('.alert-danger').append('<li>'+result.apierrors+'</li>');
                        }
                        else
                        {
                            toastr.options =
                                {
                                    "closeButton" : true,
                                    "progressBar" : true
                                }
                            toastr.success(result.success);
                            jQuery('.alert-danger').empty();
                            jQuery('.alert-danger').hide();
                            $('#myModal').modal('hide');
                            document.getElementById("form").reset();
                        }
                    }});
            });

        });
    </script>
@stop
