@auth
    @if(Auth::user()->isTU())
        <li><a href="{{route('show.agenda-masuk')}}"><i class="fa fa-envelope-open"></i> Agenda Surat Masuk</a></li>
        <li><a href="{{route('show.agenda-keluar')}}"><i class="fa fa-paper-plane"></i> Agenda Surat Keluar</a></li>
    @elseif(Auth::user()->isPegawai())
        <li><a href="{{route('show.surat-keluar')}}"><i class="fa fa-paper-plane"></i> Surat Keluar</a></li>
    @elseif(Auth::user()->isPengolah() || Auth::user()->isKadin())
        <li><a href="{{route('show.surat-masuk')}}"><i class="fa fa-envelope-open"></i> Surat Masuk</a></li>
        <li><a href="{{route('show.surat-keluar')}}"><i class="fa fa-paper-plane"></i> Surat Keluar</a></li>
    @endif
    <li><a href="{{route('show.staff')}}"><i class="fa fa-users"></i> Daftar Staff</a></li>
@endauth

@auth('admin')
    <li><a><i class="fa fa-table"></i> Tables <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a>Accounts <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{route('table.admins')}}">Admins</a></li>
                    <li><a href="{{route('table.users')}}">Users</a></li>
                </ul>
            </li>
            <li><a>Web Contents <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{route('table.carousels')}}">Carousels</a></li>
                    <li><a href="{{route('table.jenis-surat')}}">Jenis Surat</a></li>
                    <li><a href="{{route('table.perihal-surat')}}">Perihal Surat</a></li>
                </ul>
            </li>
        </ul>
    </li>
@endauth