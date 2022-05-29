@extends("menuLayouts.courseslayout")



@section("layout_content")
    <div class="row">
        <div class="col col-md-9">
            <h1>Son Etkinlikler</h1>
            <hr>
            <h2>Müfredat</h2>
            <p>{!! (!empty($course->syllabus_body)) ? $course->syllabus_body : "Müfredat eklenmemiş" !!}</p>
        </div>
        <div class="col col-md-3">
            @include('menuLayouts.coursesRightMenu')
        </div>
    </div>
@endsection
