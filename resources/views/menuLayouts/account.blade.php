<nav class="navbar navbar-light bg-light">
    <ul class="navbar-nav">
    <li class="navbar-item">
        <a class="nav-link {{(request()->routeIs("accounts.spesific")) ? 'active' : ''}}" href="{{route('accounts.spesific',[
                        "id" => request()->route()->id
                    ])}}">Dersler</a>
    </li>
    <li class="navbar-item">
        <a class="nav-link {{(request()->routeIs("accounts.users.index")) ? 'active' : ''}}" href="{{route('accounts.users.index',[
                        "id" => request()->route()->id
                    ])}}">Kişiler</a>
    </li>
    <li class="navbar-item">
        <a class="nav-link {{(request()->routeIs("accounts.donemler.index")) ? 'active' : ''}}" href="{{route('accounts.donemler.index',[
                        "id" => request()->route()->id
                    ])}}">Dönemler</a>
    </li>
        <li class="navbar-item">
            <a href="#" class="nav-link">İstatistikler</a>
        </li>
        <li class="navbar-item">
            <a href="#" class="nav-link">Alt Hesaplar</a>
        </li>
        <li class="navbar-item">
            <a href="#" class="nav-link">Soru Bankaları</a>
        </li>
        <li class="navbar-item">
            <a href="#" class="nav-link">Ayarlar</a>
        </li>
        <li class="navbar-item">
            <a href="#" class="nav-link">Öğretim Üyesi Günlüğü</a>
        </li>
    </ul>

</nav>

@push('css')
    <style>
       .navbar-item .nav-link{
            font-size:18px;
       }
    </style>
@endpush
