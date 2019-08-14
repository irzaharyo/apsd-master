<script>
    @if(session('token'))
    swal('Validasi Token Kadaluarsa!', '{{session('token')}}', 'error');

    @elseif(session('signed'))
    swal('Masuk!', 'Selamat datang {{Auth::guard('admin')->check() ? Auth::guard('admin')->user()->name :
    Auth::user()->name}}! Anda telah masuk.', 'success');

    @elseif(session('expire'))
    swal('Diperlukan Otentikasi!', '{{ session('expire') }}', 'error');

    @elseif(session('logout'))
    swal('Keluar!', '{{ session('logout') }}', 'warning');

    @elseif(session('warning'))
    swal('PERHATIAN!', '{{ session('warning') }}', 'warning');

    @elseif(session('resetLink') || session('recovered'))
    swal('Sukses!', '{{session('resetLink') ? session('resetLink') : session('recovered') }}', 'success');

    @elseif(session('resetLink_failed') || session('recover_failed'))
    swal('Kesalahan!', '{{session('resetLink_failed') ? session('resetLink_failed') : session('recover_failed') }}', 'error');

    @elseif(session('add'))
    swal('Pengaturan Profil', '{{ session('add') }}', 'success');

    @elseif(session('update'))
    swal('Sukses!', '{{ session('update') }}', 'success');

    @elseif(session('delete'))
    swal('Sukses!', '{{ session('delete') }}', 'success');

    @elseif(session('error'))
    swal('Pengaturan Profil', '{{ session('error') }}', 'error');
    @endif

    @if (count($errors) > 0)
    @foreach ($errors->all() as $error)
    swal('Oops..!', '{{ $error }}', 'error');
    @endforeach
    @endif
</script>