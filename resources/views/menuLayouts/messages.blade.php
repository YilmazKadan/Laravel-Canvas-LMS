@if ($notification = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $notification }}</strong>
    </div>
@endif


@if ($notification = Session::get('apierrors'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $notification }}</strong>
    </div>
@endif
