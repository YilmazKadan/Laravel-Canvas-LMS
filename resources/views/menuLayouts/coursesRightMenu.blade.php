<div class="button d-flex">
    @if($course->workflow_state == "unpublished")
    <a href="#" class="btn btn-danger">Yayınlanmadı</a>
    <a href="{{route("courses.publish",["id" => $course->id])}}" class="btn btn-outline-secondary">Yayınla</a>
    @elseif($course->workflow_state == "available")
        <a href="#" class="btn btn-success">Yayınlandı</a>
        <a href="{{route("courses.unpublish",["id" => $course->id])}}" class="btn btn-outline-secondary">Yayından kaldır</a>
    @endif

</div>
