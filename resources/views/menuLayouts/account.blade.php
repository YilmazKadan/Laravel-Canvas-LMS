<ul>
    <li>
        <a href="{{route('accounts.spesific',[
                        "id" => request()->route()->id
                    ])}}">Dersler</a>
    </li>
    <li>
        <a href="{{route('accounts.users',[
                        "id" => request()->route()->id
                    ])}}">Kişiler</a>
    </li>
    <li>
        <a href="{{route('accounts.index',[
                        "id" => request()->route()->id
                    ])}}">Dönemler</a>
    </li>
</ul>
