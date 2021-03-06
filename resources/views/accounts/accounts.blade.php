@section('plugins.Datatables', true)
@section('plugins.toastr', true)
@section('plugins.Select2',true)

@extends('adminlte::page')

@section('title', $account->name)

@section('content_header')
    <h1>{{$account->name}}</h1>
@stop

@section('content')
    <div class="row">
        <form method="post" action="{{route('courses.store')}}" id="form">
        @csrf
        <!-- Modal -->
            <div class="modal" tabindex="-1" role="dialog" id="myModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="alert alert-danger" style="display:none"></div>
                        <div class="modal-header">

                            <h5 class="modal-title">Yeni Ders Ekle</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-7">
                                    <label for="name">Ders Adı:</label>
                                    <input type="text" class="form-control" name="name" id="name">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-7">
                                    <label for="course_code">Refersan Kodu:</label>
                                    <input type="text" class="form-control" name="course_code" id="course_code">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-7">
                                    <div>
                                        <label for="course_code">Hesap</label>
                                    </div>
                                    <select class="form-control" name="account_id" id="account_id">
                                        @foreach($accounts as $localaccount)
                                        <option {{($localaccount->id == $account->id) ? "selected" : ''}} value="{{$localaccount->id}}">{{$localaccount->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-7">
                                    <div>
                                        <label for="course_code">Hesap</label>
                                    </div>
                                    <select class="form-control" name="term_id" id="account_term">
                                        @foreach($terms as $term)
                                        <option  value="{{$term->id}}">{{$term->name}}</option>
                                        @endforeach
                                    </select>
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
        <div class="col col-md-2">
            @include('menuLayouts.account')
        </div>
        <div class="col col-md-10">
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
                            <th scope="col">Başlama Tarihi</th>
                            <th scope="col">Oluşturulma Tarihi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($dersler as $ders)
                            <tr>
                                <th>{{$ders->id}}</th>
                                <td>{{$ders->name}}</td>
                                <td>{{$ders->course_code}}</td>
                                <td>{{$ders->start_at}}</td>
                                <td>{{$ders->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        </div>
    </div>
    </div>
@stop
@section('css')
@stop

@section('js')
    <script>
        $(document).ready(function () {

            $('#tablo').DataTable();
            $('#account_id').select2({
                dropdownParent : $('#myModal'),
                width: "100%"
            });

            jQuery('#ajaxSubmit').click(function(e){
                e.preventDefault();
                let url = "{{ route('courses.store') }}";
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: url,
                    method: 'post',
                    dataType : "json",
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
