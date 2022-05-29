@extends("menuLayouts.courseslayout")

@section('plugins.Datatables', true)
@section('plugins.toastr', true)
@section('plugins.Select2',true)



@section("layout_content")
    <div class="row">
        <form method="post" action="{{route('courses.enrollments.store',["id" => $course->id])}}" id="form">
        @csrf
        <!-- Modal -->
            <div class="modal fade bd-example-modal-lg show "tabindex="-1" role="dialog" id="myModal">
                <div class="modal-dialog modal-lg show" role="document">
                    <div class="modal-content">
                        <div class="alert alert-danger" style="display:none"></div>
                        <div class="modal-header">
                            <h5 class="modal-title">Yeni Katılımcı Ekle</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-7">
                                    <div>
                                        <label for="course_code">Rol</label>
                                    </div>
                                    <select class="form-control" name="role_id" id="role_id">
                                        @foreach($roles as $role)
                                            @if($role->base_role_type != "AccountMembership")
                                            <option  value="{{$role->id}}">{{$role->label}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-7">
                                    <div>
                                        <label for="user_id">User</label>
                                    </div>
                                    <select class="form-control" name="user_id" id="user_id">
                                        @foreach($users as $user)
                                            <option  value="{{$user->id}}">{{$user->name}}</option>
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
        <div class="col">
            <div class="card">
                <div class="card-header d-flex">
                    <h3>Katılımcılar</h3>
                    <a href="" data-toggle="modal" data-target="#myModal" id="open" class="btn btn-success ml-auto">Yeni Ekle</a>
                </div>
                <div class="card-body">
                  <div class="container" style="width:100%">
                      <table style="width:100%" class="table table table-bordered table-responsive table-hover dataTable dtr-inline" id="tablo">
                          <thead>
                          <tr>
                              <th scope="col">Ad</th>
                              <th scope="col">Giriş ID</th>
                              <th scope="col">ÖBS ID</th>
                              <th scope="col">Bölüm</th>
                              <th scope="col">Rol</th>
                              <th scope="col">Son Etkinlik</th>

                          </tr>
                          </thead>
                          <tbody>
                          @foreach ($enrollments as $enrollment)
                              <tr>
                                  <td>{{$enrollment->user->name}}</td>
                                  <td>{{$enrollment->user->login_id}}</td>
                                  <td>{{$enrollment->sis_user_id}}</td>
                                  <td>{{$course->name}}</td>
                                  <td>{{__($enrollment->role)}}</td>
                                  <td>{{$enrollment->last_activity_at}}</td>

                              </tr>
                          @endforeach
                          </tbody>
                      </table>
                  </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {

            $('#tablo').DataTable({
                responsive: true
            });

            jQuery('#ajaxSubmit').click(function(e){
                e.preventDefault();
                let url = $('#form').attr("action");
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
@endsection
