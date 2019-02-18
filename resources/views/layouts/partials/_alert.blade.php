<script>
    @if(session('token'))
    swal('Validation Token Expired!', '{{session('token')}}', 'error');

    @elseif(session('signed'))
    swal('Signed In!', 'Welcome {{Auth::guard('admin')->check() ? Auth::guard('admin')->user()->name :
    Auth::user()->name}}! You\'re now signed in.', 'success');

    @elseif(session('expire'))
    swal('Authentication Required!', '{{ session('expire') }}', 'error');

    @elseif(session('logout'))
    swal('Signed Out!', '{{ session('logout') }}', 'warning');

    @elseif(session('warning'))
    swal('ATTENTION!', '{{ session('warning') }}', 'warning');

    @elseif(session('resetLink') || session('recovered'))
    swal('Success!', '{{session('resetLink') ? session('resetLink') : session('recovered') }}', 'success');

    @elseif(session('resetLink_failed') || session('recover_failed'))
    swal('Error!', '{{session('resetLink_failed') ? session('resetLink_failed') : session('recover_failed') }}', 'error');

    @elseif(session('add'))
    swal('Profile Settings', '{{ session('add') }}', 'success');

    @elseif(session('update'))
    swal('Success!', '{{ session('update') }}', 'success');

    @elseif(session('delete'))
    swal('Success!', '{{ session('delete') }}', 'success');

    @elseif(session('error'))
    swal('Profile Settings', '{{ session('error') }}', 'error');
    @endif

    @if (count($errors) > 0)
    @foreach ($errors->all() as $error)
    swal('Oops..!', '{{ $error }}', 'error');
    @endforeach
    @endif
</script>