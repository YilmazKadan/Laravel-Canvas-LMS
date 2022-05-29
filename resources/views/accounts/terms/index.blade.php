@extends('adminlte::page')

@section('title', 'Dönemler')

@section('content_header')
    <h1>Dönemler</h1>
@stop

@section('content')
    <form method="post" action="{{route('accounts.donemler.store',["id" => request()->route()->id])}}" id="form">
    @csrf
    <!-- Modal -->
        <div class="modal" tabindex="-1" role="dialog" id="myModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="alert alert-danger" style="display:none"></div>
                    <div class="modal-header">

                        <h5 class="modal-title">Yeni Dönem Ekle</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label for="name">Dönem Adı</label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label for="course_code">Başlangıç</label>
                                <div class="input-group date" id="start_at" data-target-input="nearest">
                                    <input type="text" name="start_at" class="form-control datetimepicker-input" data-target="#start_at"/>
                                    <div class="input-group-append" data-target="#start_at" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label for="course_code">Başlangıç</label>
                                <div class="input-group date" id="end_at" data-target-input="nearest">
                                    <input type="text" name = "end_at" class="form-control datetimepicker-input" data-target="#end_at"/>
                                    <div class="input-group-append" data-target="#end_at" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
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
                <h3>Dönemler</h3>
                <a href="#" data-target="#myModal" data-toggle="modal" class="btn btn-success ml-auto">Yeni Ekle</a>
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
                                <a href="#" class="btn btn-primary">Güncelle</a>
                                <a href="#" class="btn btn-danger sil-btn" data-id = "{{$donem->id}}">Sil</a>
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
@section("plugins.moment",true)
@section("plugins.tempusdominus",true)
@section('plugins.Datatables', true)
@section('plugins.toastr', true)
@section("plugins.Sweetalert2",true)
@section('css')
@stop

@section('js')
    <script>
        $(document).ready(function () {
            $('#tablo').DataTable();

            //Date picker
            $('#start_at').datetimepicker({
                 format:'DD/MM/YYYY'
            });
            $('#end_at').datetimepicker({
                 format:'DD/MM/YYYY'
            });

            //CREATE A TERM

            jQuery('#ajaxSubmit').click(function(e){
                e.preventDefault();
                let url = "{{ route('accounts.donemler.store',["id" => request()->route()->id])}}";
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
                        console.log(result);
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
                            toastr.success(result.success);
                            jQuery('.alert-danger').empty();
                            jQuery('.alert-danger').hide();
                            $('#myModal').modal('hide');
                            document.getElementById("form").reset();
                        }
                    }});
            });
            //Delete a term
            const termUrl = "{{route('accounts.donemler.index',["id" => request()->route()->id])}}";
            $(document).on('click',".sil-btn",function (e){
                const termId = $(e.currentTarget).data("id");
                Swal.fire({
                    title: 'Silme işleminin geri dönüşü olmayabilir. Emin misiniz ?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#5cb85c',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Vazgeç',
                    confirmButtonText: 'Sil',
                    }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            "method": "delete",
                            url: termUrl + "/" + termId,
                            dataType: "json",
                            data:{"_token": "{{csrf_token()}}"},
                            success: function(response){
                                if(response.success){
                                    swal.fire({
                                        title: 'Başarılı',
                                        text: response.success,
                                        type: 'success',
                                        timer: 4000,
                                    }).then(function(){
                                       location.reload();
                                    });
                                }
                                else if(response.apierrors){
                                    swal.fire({
                                        title: 'Error',
                                        text: response.apierrors,
                                        type: 'error',
                                        timer: 4000,
                                    })
                                }
                            }
                        });
                    } else{
                        Swal.fire('İşlem iptal', '', 'info')
                    }
                })
            });

        });
    </script>
@stop
