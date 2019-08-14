<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akun | {{env('APP_NAME')}} &mdash; Aplikasi Pengarsipan Surat dan Disposisi | Dinas Pertanian dan Ketahanan
        Pangan
        Kota Madiun</title>
    <link rel="icon" href="{{asset('favicon.ico')}}" type="image/ico"/>
    <!-- Bootstrap -->
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('fonts/fontawesome-free/css/all.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{asset('css/nprogress.css')}}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{asset('css/animate.min.css')}}" rel="stylesheet">
    <!-- Sweet Alert v2 -->
    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
    <script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Custom Theme Style -->
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/signIn-Up.css')}}" rel="stylesheet">
    <script src='https://www.google.com/recaptcha/api.js?onload=recaptchaCallback&render=explicit' async defer></script>
</head>

<body>
<div class="wrapper">
    <div class="sign-panels">
        <!-- Sign in form -->
        <div class="login">
            <div class="title">
                <span>Masuk</span>
                <p>Silahkan masuk menggunakan akun {{env('APP_NAME')}} Anda.</p>
            </div>
            @if(session('recovered'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Alert!</h4>
                    {{session('recovered')}}
                </div>
            @elseif(session('error') || session('inactive'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-times"></i> Alert!</h4>
                    {{session('error') ? session('error') : session('inactive')}}
                </div>
            @endif
            <form class="form-horizontal" method="post" accept-charset="UTF-8" action="{{route('login')}}"
                  id="form-login">
                {{ csrf_field() }}
                <div class="row form-group has-feedback">
                    <input type="email" placeholder="Email" name="email" value="{{ old('email') }}" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="row form-group has-feedback">
                    <input id="log_password" type="password" placeholder="Kata sandi" name="password" minlength="6"
                           required>
                    <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                </div>
                <div class="row form-group">
                    <div class="col-lg-4">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Biarkan saya tetap masuk</label>
                    </div>
                    <div class="col-lg-8" id="recaptcha-login"></div>
                </div>
                <div class="row">
                    <button id="btn_login" type="submit" class="btn btn-signin btn-block" disabled>MASUK</button>
                </div>
                @if(session('error'))
                    <strong>{{ $errors->first('password') }}</strong>
                @endif
                <a href="javascript:void(0)" class="btn-reset btn-fade">Lupa kata sandi?
                    <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
            </form>
        </div>

        <!-- Reset & Recover password form -->
        <div class="recover-password" style="display: none;">
            <div class="title">
                <span>{{session('reset') || session('recover_failed') ? 'Recovery' : 'Reset'}} Kata Sandi</span>
                <p>
                    {{session('reset') || session('recover_failed') ? 'Silahkan masukkan password baru Anda ' :
                    'Untuk memulihkan password Anda, silahkan masukkan email akun '.env('APP_NAME').' Anda.'}}
                </p>
            </div>
            @if(session('resetLink') || session('resetLink_failed'))
                <div class="alert alert-{{session('resetLink') ? 'success' : 'danger'}} alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-{{session('resetLink') ? 'check' : 'times'}}"></i> Alert!</h4>
                    {{session('resetLink') ? session('resetLink') : session('resetLink_failed')}}
                </div>
            @elseif(session('recover_failed'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-times"></i> Alert!</h4>{{ session('recover_failed') }}
                </div>
            @endif
            <form id="form-recovery" class="form-horizontal" method="post" accept-charset="UTF-8"
                  action="{{session('reset') || session('recover_failed') ? route('password.request',
                  ['token' => session('reset') ? session('reset')['token'] : old('token')]) : route('password.email')}}">
                {{ csrf_field() }}
                <div class="row form-group has-feedback">
                    <input type="email" placeholder="Email" id="resetPassword" name="email" value="{{ old('email') }}"
                           required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    <span class="error"></span>
                </div>
                @if(session('reset') || session('recover_failed'))
                    <div class="row form-group has-feedback error_forgPass">
                        <input id="forg_password" type="password" placeholder="Kata sandi baru" name="password"
                               minlength="6" required>
                        <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                    </div>
                    <div class="row form-group has-feedback error_forgPass">
                        <input id="forg_password_confirm" type="password" placeholder="Retype password" required
                               name="password_confirmation" minlength="6" onkeyup="return checkForgotPassword()">
                        <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                        <span class="help-block"><strong class="aj_forgPass"
                                                         style="text-transform: none"></strong></span>
                    </div>
                @endif
                <div class="row">
                    <button type="submit" class="btn btn-signup btn-password">
                        {{session('reset')||session('recover_failed') ? 'Reset Kata Sand' : 'Kirim Tautan Reset Kata Sandi'}}
                    </button>
                </div>
                <a href="javascript:void(0)" class="btn-login btn-fade">Sudah punya akun? Masuk
                    <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
            </form>
        </div>
    </div>
</div>
</body>
<!-- jQuery -->
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/hideShowPassword.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script>
    $('[data-toggle="tooltip"]').tooltip();

    $('.btn-reset').on("click", function () {
        $('.login').hide();
        $('.recover-password').fadeIn(300);
    });

    $('.btn-login').on("click", function () {
        $('.recover-password').hide();
        $('.login').fadeIn(300);
    });

    @if(session('resetLink') || session('resetLink_failed') || session('reset') || session('recover_failed'))
    $(".btn-reset").click();
            @endif

    var recaptcha_login, recaptchaCallback = function () {
            recaptcha_login = grecaptcha.render(document.getElementById('recaptcha-login'), {
                'sitekey': '{{env('reCAPTCHA_v2_SITEKEY')}}',
                'callback': 'enable_btnLogin',
                'expired-callback': 'disabled_btnLogin'
            });
        };

    function enable_btnLogin() {
        $("#btn_login").removeAttr('disabled');
    }

    function disabled_btnLogin() {
        $("#btn_login").attr('disabled', 'disabled');
    }

    $("#form-login").on("submit", function (e) {
        if (grecaptcha.getResponse(recaptcha_login).length === 0) {
            e.preventDefault();
            swal('ATTENTION!', 'Mohon klik kotak dialog reCAPTCHA berikut.', 'warning');
        }
    });

    function checkForgotPassword() {
        var new_pas = $("#forg_password").val(),
            re_pas = $("#forg_password_confirm").val();
        if (new_pas != re_pas) {
            $(".error_forgPass").addClass('has-error');
            $(".aj_forgPass").text("Harus cocok dengan password baru Anda!");
            $(".btn-password").attr('disabled', 'disabled');
        } else {
            $(".error_forgPass").removeClass('has-error');
            $(".aj_forgPass").text("");
            $(".btn-password").removeAttr('disabled');
        }
    }

    $("#form-recovery").on("submit", function (e) {
        @if(session('reset') || session('recover_failed'))
        if ($("#forg_password_confirm").val() != $("#forg_password").val()) {
            $(".btn-password").attr('disabled', 'disabled');
            return false;

        } else {
            $("#forg_errorAlert").html('');
            $(".btn-password").removeAttr('disabled');
            return true;
        }
        @endif
    });

    $('#log_password + .glyphicon').on('click', function () {
        $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
        $('#log_password').togglePassword();
    });

    $('#forg_password + .glyphicon').on('click', function () {
        $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
        $('#forg_password').togglePassword();
    });

    $('#forg_password_confirm + .glyphicon').on('click', function () {
        $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
        $('#forg_password_confirm').togglePassword();
    });

    var title = document.getElementsByTagName("title")[0].innerHTML;
    (function titleScroller(text) {
        document.title = text;
        setTimeout(function () {
            titleScroller(text.substr(1) + text.substr(0, 1));
        }, 500);
    }(title + " ~ "));
</script>
@include('layouts.partials._alert')
</html>
