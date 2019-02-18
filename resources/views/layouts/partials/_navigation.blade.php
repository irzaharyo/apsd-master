@auth
    <li><a href="{{route('show.suratMasuk')}}"><i class="fa fa-envelope-open"></i> Surat Masuk</a></li>
    <li><a href="{{route('show.suratDisposisi')}}"><i class="fa fa-envelope"></i> Surat Disposisi</a></li>
    <li><a href="{{route('show.suratKeluar')}}"><i class="fa fa-paper-plane"></i> Surat Keluar</a></li>
@endauth

@auth('admin')
    <li><a href="{{route('show.suratMasuk')}}"><i class="fa fa-envelope-open"></i> Surat Masuk</a></li>
    <li><a href="{{route('show.suratDisposisi')}}"><i class="fa fa-envelope"></i> Surat Disposisi</a></li>
    <li><a href="{{route('show.suratKeluar')}}"><i class="fa fa-paper-plane"></i> Surat Keluar</a></li>
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