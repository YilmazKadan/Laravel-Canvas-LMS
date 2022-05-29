<nav class="navbar navbar-light bg-light">
    <ul class="navbar-nav">
        <li class="navbar-item">
            <a class="nav-link {{(request()->routeIs("courses.spesific")) ? 'active' : ''}}" href="{{route('courses.spesific',[
                        "id" => request()->route()->id
                    ])}}">Anasayfa</a>
        </li>
        <li class="navbar-item">
            <a href="#" class="nav-link">İstatistikler</a>
        </li>
    </ul>

</nav>

@push('css')
    <style>
        .navbar-item .nav-link{
            font-size:20px;
        }
    </style>
@endpush
