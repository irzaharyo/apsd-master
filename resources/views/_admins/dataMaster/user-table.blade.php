@extends('layouts.mst')
@section('title', 'Halaman Admin: Tabel User | '.env('APP_NAME').' - Aplikasi Pengarsipan Surat dan Disposisi | Dinas Pertanian dan Ketahanan Pangan Kota Madiun')
@push("styles")
    <style>
        .dataTables_filter {
            /*width: 70%;*/
            width: auto;
        }

        #password + .glyphicon, #new_password + .glyphicon, #confirm + .glyphicon {
            cursor: pointer;
            pointer-events: all;
        }
    </style>
@endpush
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Users
                            <small id="panel_title">Table</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link" data-toggle="tooltip" title="Minimize" data-placement="left">
                                    <i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="btn_create" data-toggle="tooltip" title="Create" data-placement="right">
                                    <i class="fa fa-plus"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div id="content1" class="x_content">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Detail</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($users as $user)
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle">
                                        <table>
                                            <tr>
                                                <td>
                                                    <a href="{{route('show.profile', ['role' => $user->role,
                                                    'id' => encrypt($user->id)])}}" target="_blank"
                                                       style="float: left;margin-right: .5em;margin-bottom: .5em">
                                                        <img class="img-responsive" width="100" alt="avatar.png"
                                                             src="{{$user->ava == "" || $user->ava == "avatar.png" ?
                                                             asset('images/avatar.png') :
                                                             asset('storage/users/'.$user->ava)}}">
                                                    </a>
                                                    <table style="margin: 0">
                                                        <tr>
                                                            <td><i class="fa fa-id-card"></i>&nbsp;</td>
                                                            <td>NIP</td>
                                                            <td>&nbsp;:&nbsp;</td>
                                                            <td>{{$user->nip}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-user-tie"></i>&nbsp;</td>
                                                            <td>Nama Lengkap</td>
                                                            <td>&nbsp;:&nbsp;</td>
                                                            <td>{{$user->name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-briefcase"></i>&nbsp;</td>
                                                            <td>Jabatan</td>
                                                            <td>&nbsp;:&nbsp;</td>
                                                            <td>{{$user->jabatan}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-transgender"></i>&nbsp;</td>
                                                            <td>Jenis Kelamin</td>
                                                            <td>&nbsp;:&nbsp;</td>
                                                            <td>{{ucfirst($user->jk)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-home"></i>&nbsp;</td>
                                                            <td>Alamat</td>
                                                            <td>&nbsp;:&nbsp;</td>
                                                            <td>{{$user->alamat}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-phone"></i>&nbsp;</td>
                                                            <td>Nomor Hp/Telp.</td>
                                                            <td>&nbsp;:&nbsp;</td>
                                                            <td>{{$user->nmr_hp}}</td>
                                                        </tr>
                                                    </table>
                                                    <hr style="margin: .5em 0">
                                                    <table style="margin: 0">
                                                        <tr>
                                                            <td><i class="fa fa-envelope"></i>&nbsp;</td>
                                                            <td>E-mail</td>
                                                            <td>&nbsp;:&nbsp;</td>
                                                            <td>{{$user->email}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-user-shield"></i>&nbsp;</td>
                                                            <td>Role</td>
                                                            <td>&nbsp;:&nbsp;</td>
                                                            <td>{{ucfirst($user->role)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-clock"></i>&nbsp;</td>
                                                            <td>Last Update</td>
                                                            <td>&nbsp;:&nbsp;</td>
                                                            <td>{{\Carbon\Carbon::parse($user->updated_at)
                                                ->format('l, j F Y - h:i:s')}}</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-warning btn-sm"
                                                    style="font-weight: 600"
                                                    onclick="editProfile('{{$user->id}}','{{$user->ava}}','{{$user->name}}',
                                                            '{{$user->nip}}','{{$user->jabatan}}','{{$user->jk}}',
                                                            '{{$user->nmr_hp}}','{{$user->alamat}}',
                                                            '{{$user->lat}}','{{$user->long}}')">
                                                <i class="fa fa-user-edit"></i>&ensp;EDIT PROFILE
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a onclick="accountSettings('{{$user->id}}','{{$user->email}}',
                                                            '{{$user->role}}')">
                                                        <i class="fa fa-user-cog"></i>&ensp;Account Settings
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{route('delete.users',['id'=> encrypt($user->id)])}}"
                                                       class="delete-data"><i class="fa fa-trash-alt"></i>&ensp;Delete
                                                        Account
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="content2" class="x_content" style="display: none">
                        <form method="post" action="{{route('create.users')}}" enctype="multipart/form-data"
                              id="form-user">
                            {{csrf_field()}}
                            <input id="method" type="hidden" name="_method">
                            <div class="row form-group profile_settings">
                                <img id="user_ava_img" class="img-responsive"
                                     style="margin: 0 auto;width: 25%;cursor: pointer"
                                     data-toggle="tooltip" data-placement="bottom"
                                     title="Ekstensi file yang boleh diunggah: jpg, jpeg, gif, png. Ukuran file maksimal: < 2 MB">
                                <hr id="user_divider" style="margin: .5em auto">
                                <div class="col-lg-12">
                                    <label for="ava">Avatar <span class="required">*</span></label>
                                    <input type="file" name="ava" style="display: none;" accept="image/*" id="ava">
                                    <div class="input-group">
                                        <input type="text" id="txt_ava" class="browse_files form-control"
                                               placeholder="Upload file here..." readonly style="cursor: pointer"
                                               data-toggle="tooltip" data-placement="top"
                                               title="Ekstensi file yang boleh diunggah: jpg, jpeg, gif, png. Ukuran file maksimal: < 2 MB">
                                        <span class="input-group-btn">
                                            <button class="browse_files btn btn-info" type="button">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group profile_settings">
                                <div class="col-lg-10 has-feedback">
                                    <label for="name">Nama Lengkap <span class="required">*</span></label>
                                    <input id="name" type="text" class="form-control" maxlength="191" name="name"
                                           placeholder="Nama lengkap" required>
                                    <span class="fa fa-user-tie form-control-feedback right"
                                          aria-hidden="true"></span>
                                </div>
                                <div class="col-lg-2">
                                    <label for="jk">Jenis Kelamin <span class="required">*</span></label>
                                    <div class="radio" id="jk">
                                        <label style="padding: 0 1em 0 0">
                                            <input id="pria" type="radio" class="flat" name="jk"
                                                   value="pria" required> Pria</label>
                                        <label style="padding: 0 1em 0 0">
                                            <input id="wanita" type="radio" class="flat" name="jk"
                                                   value="wanita"> Wanita</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group profile_settings">
                                <div class="col-lg-6 has-feedback">
                                    <label for="nip">NIP <span class="required">*</span></label>
                                    <input id="nip" type="text" class="form-control" name="nip" placeholder="NIP"
                                           onkeypress="return numberOnly(event, false)" required>
                                    <span class="fa fa-id-card form-control-feedback right"
                                          aria-hidden="true"></span>
                                </div>
                                <div class="col-lg-6 has-feedback">
                                    <label for="jabatan">Jabatan <span class="required">*</span></label>
                                    <input id="jabatan" placeholder="Jabatan" type="text" class="form-control"
                                           name="jabatan" required>
                                    <span class="fa fa-briefcase form-control-feedback right"
                                          aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="row form-group profile_settings">
                                <div class="col-lg-6">
                                    <div id="map" style="width:100%;height: 200px;"></div>
                                    <div id="infowindow-content" style="display: none;">
                                        <img src="{{asset('images/Kota Madiun.png')}}" width="32" id="place-icon">
                                        <span id="place-name" class="title">Dinas Pertanian Dan Ketahanan Pangan Kota Madiun</span><br>
                                        <span id="place-address">Nambangan Lor, Mangu Harjo, Kota Madiun, Jawa Timur 63161</span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row form-group">
                                        <div class="col-lg-12 has-feedback">
                                            <label for="address_map">Alamat Lengkap <span
                                                        class="required">*</span></label>
                                            <textarea style="resize:vertical" name="alamat" id="address_map"
                                                      class="form-control"
                                                      placeholder="Alamat lengkap" rows="4" required></textarea>
                                            <span class="fa fa-map-marked-alt form-control-feedback right"
                                                  aria-hidden="true"></span>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-12 has-feedback">
                                            <label for="nmr_hp">Nomor Hp/Telp. <span
                                                        class="required">*</span></label>
                                            <input id="nmr_hp" placeholder="Nomor hp/telp. yang masih aktif"
                                                   type="text" required
                                                   class="form-control" name="nmr_hp"
                                                   onkeypress="return numberOnly(event, false)">
                                            <span class="fa fa-phone form-control-feedback right"
                                                  aria-hidden="true"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group account_settings">
                                <div class="col-lg-12 has-feedback">
                                    <label for="role">Role <span class="required">*</span></label>
                                    <select id="role" class="form-control selectpicker" name="role"
                                            data-live-search="true" title="-- Pilih Role --" required>
                                        <option value="kadin" {{\App\Models\User::where('role', \App\Support\Role::KADIN)
                                        ->count() > 0 ? 'disabled' : ''}}>Kepala Dinas
                                        </option>
                                        <option value="pengolah">Pengolah</option>
                                        <option value="pegawai">Pegawai</option>
                                        <option value="tata_usaha">Tata Usaha</option>
                                    </select>
                                    <span class="fa fa-user-shield form-control-feedback right"
                                          aria-hidden="true"></span>
                                    <span style="color: #fa5555">NB: Jika ingin menambahkan Akun KADIN, Anda harus menghapus akun
                                        KADIN yang tersedia atau mengubah hak aksesnya.</span>
                                </div>
                            </div>
                            <div class="row form-group account_settings">
                                <div class="col-lg-6 has-feedback">
                                    <label for="email">Email <span class="required">*</span></label>
                                    <input id="email" type="email" class="form-control" name="email"
                                           placeholder="Email" required>
                                    <span class="fa fa-envelope form-control-feedback right"
                                          aria-hidden="true"></span>
                                </div>
                                <div class="col-lg-6 has-feedback">
                                    <label for="password">Password <span class="required">*</span></label>
                                    <input id="password" type="password" class="form-control" minlength="6"
                                           name="password" placeholder="Password" required>
                                    <span class="glyphicon glyphicon-eye-open form-control-feedback right"
                                          aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="row form-group account_settings">
                                <div class="col-lg-6 has-feedback" style="display: none;">
                                    <label for="new_password">New Password <span class="required">*</span></label>
                                    <input id="new_password" type="password" class="form-control" minlength="6"
                                           name="new_password" placeholder="New password" required>
                                    <span class="glyphicon glyphicon-eye-open form-control-feedback right"
                                          aria-hidden="true"></span>
                                </div>
                                <div class="col-lg-12 has-feedback">
                                    <label for="confirm">Password Confirmation <span class="required">*</span></label>
                                    <input id="confirm" type="password" class="form-control" minlength="6"
                                           name="password_confirmation" placeholder="Retype password" required>
                                    <span class="glyphicon glyphicon-eye-open form-control-feedback right"
                                          aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <button type="reset" class="btn btn-default btn-block" id="btn_user_cancel">
                                        <strong>BATAL</strong></button>
                                </div>
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary btn-block" id="btn_user_submit">
                                        <strong>SUBMIT</strong></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIljHbKjgtTrpZhEiHum734tF1tolxI68&libraries=places"></script>
    <script>
        var google;

        function init(lat, long) {
            var myLatlng = new google.maps.LatLng(lat, long);
            var mapOptions = {
                zoom: 15,
                center: myLatlng,
                scrollwheel: true,
                styles: [
                    {
                        "featureType": "administrative.land_parcel",
                        "elementType": "all",
                        "stylers": [{"visibility": "on"}]
                    }, {
                        "featureType": "landscape.man_made",
                        "elementType": "all",
                        "stylers": [{"visibility": "on"}]
                    }, {"featureType": "poi", "elementType": "labels", "stylers": [{"visibility": "on"}]}, {
                        "featureType": "road",
                        "elementType": "labels",
                        "stylers": [{"visibility": "simplified"}, {"lightness": 20}]
                    }, {
                        "featureType": "road.highway",
                        "elementType": "geometry",
                        "stylers": [{"hue": "#f49935"}]
                    }, {
                        "featureType": "road.highway",
                        "elementType": "labels",
                        "stylers": [{"visibility": "simplified"}]
                    }, {
                        "featureType": "road.arterial",
                        "elementType": "geometry",
                        "stylers": [{"hue": "#fad959"}]
                    }, {
                        "featureType": "road.arterial",
                        "elementType": "labels",
                        "stylers": [{"visibility": "on"}]
                    }, {
                        "featureType": "road.local",
                        "elementType": "geometry",
                        "stylers": [{"visibility": "simplified"}]
                    }, {
                        "featureType": "road.local",
                        "elementType": "labels",
                        "stylers": [{"visibility": "simplified"}]
                    }, {
                        "featureType": "transit",
                        "elementType": "all",
                        "stylers": [{"visibility": "on"}]
                    }, {
                        "featureType": "water",
                        "elementType": "all",
                        "stylers": [{"hue": "#a1cdfc"}, {"saturation": 30}, {"lightness": 49}]
                    }]
            };

            var mapElement = document.getElementById('map');

            var map = new google.maps.Map(mapElement, mapOptions);

            var marker = new google.maps.Marker({
                map: map,
                position: myLatlng,
                anchorPoint: new google.maps.Point(0, -29)
            });

            var infowindow = new google.maps.InfoWindow();
            var infowindowContent = document.getElementById('infowindow-content');
            infowindow.setContent(infowindowContent);

            marker.addListener('click', function () {
                $("#infowindow-content").show();
                infowindow.open(map, marker);
            });

            google.maps.event.addListener(map, 'click', function () {
                infowindow.close();
            });

            var autocomplete = new google.maps.places.Autocomplete(document.getElementById('address_map'));

            autocomplete.bindTo('bounds', map);

            autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

            autocomplete.addListener('place_changed', function () {
                infowindow.close();
                marker.setVisible(false);

                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    window.alert("No details available for input: '" + place.name + "'");
                    return;
                }

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }

                infowindowContent.children['place-icon'].src = place.icon;
                infowindowContent.children['place-name'].textContent = place.name;
                infowindowContent.children['place-address'].textContent = address;
                infowindow.open(map, marker);

                marker.addListener('click', function () {
                    $("#infowindow-content").show();
                    infowindow.open(map, marker);
                });

                google.maps.event.addListener(map, 'click', function () {
                    infowindow.close();
                });
            });
        }

        $(".btn_create, #btn_user_cancel").on("click", function () {
            $("#content1").toggle(300);
            $("#content2").toggle(300);
            $(".btn_create i").toggleClass('fa-plus fa-th-list');
            $(".profile_settings, .account_settings").show();
            $("#name, #pria, #nip, #jabatan, #address_map, #nmr_hp, #email, #password, #confirm, #role").attr('required', 'required');
            $("#new_password").removeAttr('required').parent().hide();
            $("#confirm").parent().removeClass('col-lg-6').addClass('col-lg-12');
            $("#method").val('');
            $("#form-user").attr('action', '{{route('create.users')}}');
            $("#btn_user_submit").html("<strong>SUBMIT</strong>");

            $(".btn_create[data-toggle=tooltip]").attr('data-original-title', function (i, v) {
                return v === "Create" ? "View" : "Create";
            }).tooltip('show');

            $("#panel_title").html(function (i, v) {
                return v === "Create Form" ? "Table" : "Create Form";
            });

            init(-7.6298, 111.5239);

            $("#name, #nip, #jabatan, #address_map, #nmr_hp, #email, #password, #confirm").val('');
            $("#pria, #wanita").iCheck('uncheck');
            $("#role").val('default').selectpicker('refresh');

            $("#user_ava_img, #user_divider").hide();
            $("#txt_ava").val('');
        });

        function editProfile(id, ava, name, nip, jabatan, jk, nmr_hp, alamat, lat, long) {
            var $ava = ava == "" || ava == "avatar.png" ? '{{asset('images/avatar.png')}}' : '{{asset('storage/users')}}/' + ava;

            $("#content1").toggle(300);
            $("#content2").toggle(300);
            $(".btn_create i").toggleClass('fa-plus fa-th-list');
            $(".profile_settings").show();
            $(".account_settings").hide();
            $("#name, #pria, #nip, #jabatan, #address_map, #nmr_hp").attr('required', 'required');
            $("#email, #password, #confirm, #role").removeAttr('required');
            $("#new_password").removeAttr('required').parent().hide();
            $("#confirm").parent().removeClass('col-lg-6').addClass('col-lg-12');
            $("#method").val('PUT');
            $("#form-user").attr("action", "{{url('admin/tables/accounts/users')}}/" + id + "/update/profile");
            $("#btn_user_submit").html("<strong>SIMPAN PERUBAHAN</strong>");

            $(".btn_create[data-toggle=tooltip]").attr('data-original-title', function (i, v) {
                return v === "Create" ? "View" : "Create";
            }).tooltip('show');

            $("#panel_title").html(function (i, v) {
                return v === "Create Form" ? "Table" : "Create Form";
            });

            init(lat, long);
            $("#place-icon").attr('src', $ava);
            $("#place-name").text(name);
            $("#place-address").text(alamat);

            $("#name").val(name);
            $("#nip").val(nip);
            $("#jabatan").val(jabatan);
            $("#address_map").val(alamat);
            $("#nmr_hp").val(nmr_hp);
            $("#" + jk).iCheck('check');

            $("#user_ava_img, #user_divider").show();
            $("#user_ava_img").attr("src", $ava);
            $("#txt_ava").val(ava);
        }

        function accountSettings(id, email, role) {
            $("#content1").toggle(300);
            $("#content2").toggle(300);
            $(".btn_create i").toggleClass('fa-plus fa-th-list');
            $(".profile_settings").hide();
            $(".account_settings").show();
            $("#name, #pria, #nip, #jabatan, #address_map, #nmr_hp").removeAttr('required');
            $("#email, #password, #confirm, #role").attr('required', 'required');
            $("#new_password").attr('required', 'required').parent().show();
            $("#confirm").parent().removeClass('col-lg-12').addClass('col-lg-6');
            $("#method").val('PUT');
            $("#form-user").attr("action", "{{url('admin/tables/accounts/users')}}/" + id + "/update/account");
            $("#btn_user_submit").html("<strong>SIMPAN PERUBAHAN</strong>");

            $(".btn_create[data-toggle=tooltip]").attr('data-original-title', function (i, v) {
                return v === "Create" ? "View" : "Create";
            }).tooltip('show');

            $("#panel_title").html(function (i, v) {
                return v === "Create Form" ? "Table" : "Create Form";
            });

            $("#email").val(email);
            $("#role").val(role).selectpicker('refresh');
        }

        $(".browse_files").on('click', function () {
            $("#ava").trigger('click');
        });

        $("#ava").on('change', function () {
            var files = $(this).prop("files");
            var names = $.map(files, function (val) {
                return val.name;
            });
            var txt = $("#txt_ava");
            txt.val(names);
            $("#txt_ava[data-toggle=tooltip]").attr('data-original-title', names).tooltip('show');
        });

        $('#password + .glyphicon').on('click', function () {
            $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
            $('#password').togglePassword();
        });

        $('#new_password + .glyphicon').on('click', function () {
            $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
            $('#new_password').togglePassword();
        });

        $('#confirm + .glyphicon').on('click', function () {
            $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
            $('#confirm').togglePassword();
        });
    </script>
@endpush
