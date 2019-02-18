@auth
    <li><a href="{{route('show.surat-masuk')}}"><i
                    class="fa fa-envelope-open"></i> {{Auth::user()->isKadin() ? 'Surat Masuk & Disposisi' : 'Surat Masuk'}}
        </a></li>
    <li><a href="{{route('show.surat-keluar')}}"><i class="fa fa-paper-plane"></i> Surat Keluar</a></li>
@endauth

@auth('admin')
    <li><a href="{{route('show.surat-masuk')}}"><i class="fa fa-envelope-open"></i> Surat Masuk & Disposisi</a></li>
    <li><a href="{{route('show.surat-keluar')}}"><i class="fa fa-paper-plane"></i> Surat Keluar</a></li>
    <li><a><i class="fa fa-table"></i> Tables <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a>Accounts <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{route('table.admins')}}">Admins</a></li>
                    <li><a href="{{route('table.users')}}">Users</a></li>
                </ul>
            </li>
        </ul>
    </li>
@endauth