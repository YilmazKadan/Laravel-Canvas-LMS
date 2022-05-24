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
    </ul>

</nav>
