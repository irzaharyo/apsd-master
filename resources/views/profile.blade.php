@extends('layouts.mst')
@section('title', 'Profil '.ucfirst($role).': '.$user->name.' | '.env('APP_NAME').' - Aplikasi Pengarsipan Surat dan Disposisi | Dinas Pertanian dan Ketahanan Pangan Kota Madiun')
@push("styles")
    <style>
        .height1 {
            height: 420px;
        }

        .height2 {
            height: 290px;
        }

        .image-upload > input {
            display: none;
        }

        .image-upload label {
            cursor: pointer;
            width: 100%;
        }
    </style>
@endpush
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{$user->name}}
                            <small>Profil {{ucfirst($role)}}</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a>&nbsp;</a></li>
                            <li><a>&nbsp;</a></li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                            <div class="profile_img">
                                <div id="crop-avatar">
                                    @if(Auth::id() == $user->id)
                                        <form method="POST" id="form-ava" enctype="multipart/form-data"
                                              class="image-upload">
                                            {{ csrf_field() }}
                                            {{ method_field('put') }}
                                            <input type="hidden" name="check_form" value="ava">
                                            <label for="file-input">
                                                <img style="width: 100%" class="show_ava" alt="AVA"
                                                     src="{{$user->ava == 'avatar.png' || $user->ava == '' ?
                                                 asset('images/avatar.png') : asset('storage/users/'.$user->ava)}}"
                                                     data-placement="bottom" data-toggle="tooltip"
                                                     title="Klik disini untuk mengganti foto profil Anda!">
                                            </label>
                                            <input id="file-input" name="ava" type="file" accept="image/*">
                                            <div id="progress-upload-ava">
                                                <div class="progress-bar progress-bar-danger progress-bar-striped active"
                                                     role="progressbar" aria-valuenow="0"
                                                     aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </form>
                                    @else
                                        <a href="javascript:void(0)" onclick="showAva()">
                                            <img class="img-responsive avatar-view" src="{{$user->ava == "" ||
                                            $user->ava == "avatar.png" ? asset('images/avatar.png') :
                                            asset('storage/users/'.$user->ava)}}">
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <h3>{{$user->name}}</h3>
                            @if(Auth::id() == $user->id)
                                <button class="btn btn-warning btn-sm" id="btn_editPersonal">
                                    <strong><i class="fa fa-edit"></i>&ensp;<span>EDIT</span></strong>
                                </button>
                            @endif
                            <ul class="list-unstyled user_data">
                                <li data-placement="left" data-toggle="tooltip" title="NIP">
                                    <i class="fa fa-id-card"></i>&ensp;{{$user->nip}}</li>
                                <li data-placement="left" data-toggle="tooltip" title="Jabatan">
                                    <i class="fa fa-briefcase"></i>&ensp;{{$user->jabatan}}</li>
                                <li data-placement="left" data-toggle="tooltip" title="Pangkat">
                                    <i class="fa fa-id-badge"></i>&ensp;{{$user->pangkat}}</li>
                                <li data-placement="left" data-toggle="tooltip" title="Jenis Kelamin">
                                    <i class="fa fa-transgender"></i>&ensp;{{ucfirst($user->jk)}}</li>
                                <li data-placement="left" data-toggle="tooltip" title="E-mail">
                                    <i class="fa fa-envelope"></i>&ensp;<a
                                            href="mailto:{{$user->email}}">{{$user->email}}</a>
                                </li>
                                <li data-placement="left" data-toggle="tooltip" title="Nomor Hp/Telp.">
                                    <i class="fa fa-phone"></i>&ensp;<a href="tel:{{$user->nmr_hp}}">
                                        {{$user->nmr_hp}}</a>
                                </li>
                                <li data-placement="left" data-toggle="tooltip" title="Alamat">
                                    <i class="fa fa-home"></i>&ensp;{{$user->alamat}}
                                </li>
                            </ul>

                            @if(Auth::id() == $user->id)
                                <div id="personal_settings" style="display: none;">
                                    <form method="post" action="{{route('update.profile')}}">
                                        {{csrf_field()}}
                                        {{method_field('PUT')}}
                                        <input type="hidden" name="check_form" value="personal">
                                        <div class="row form-group">
                                            <div class="col-lg-12">
                                                <label for="nip">NIP <span class="required">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                                    <input id="nip" placeholder="NIP" type="text" class="form-control"
                                                           name="nip" onkeypress="return numberOnly(event, false)"
                                                           value="{{$user->nip}}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-12">
                                                <label for="nama">Nama Lengkap <span class="required">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i
                                                                class="fa fa-user-tie"></i></span>
                                                    <input id="nama" placeholder="Nama lengkap" type="text"
                                                           class="form-control" name="nama"
                                                           value="{{$user->name}}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-12">
                                                <label for="jabatan">Jabatan <span class="required">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i
                                                                class="fa fa-briefcase"></i></span>
                                                    <input id="jabatan" placeholder="Jabatan" type="text"
                                                           class="form-control" name="jabatan"
                                                           value="{{$user->jabatan}}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-12">
                                                <label for="pangkat">Pangkat <span class="required">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i
                                                                class="fa fa-id-badge"></i></span>
                                                    <input id="pangkat" placeholder="pangkat" type="text"
                                                           class="form-control" name="pangkat"
                                                           value="{{$user->pangkat}}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-12">
                                                <label for="nmr_hp">Nomor Hp/Telp. <span
                                                            class="required">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                    <input id="nmr_hp" placeholder="Nomor hp/telp. yang masih aktif"
                                                           type="text" class="form-control" name="nmr_hp"
                                                           onkeypress="return numberOnly(event, false)"
                                                           value="{{$user->nmr_hp}}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-12">
                                                <label for="jk">Jenis Kelamin <span class="required">*</span></label>
                                                <div class="radio" id="jk">
                                                    <label style="padding: 0 1em 0 0">
                                                        <input id="pria" type="radio" class="flat" name="jk"
                                                               value="pria" required {{$user->jk == 'pria' ?
                                                           'checked' : ''}}> Pria</label>
                                                    <label style="padding: 0 1em 0 0">
                                                        <input id="wanita" type="radio" class="flat" name="jk"
                                                               value="wanita" {{$user->jk == 'wanita' ?
                                                           'checked' : ''}}> Wanita</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-12">
                                                <button type="submit" class="btn btn-primary btn-block">
                                                    <strong>SIMPAN PERUBAHAN</strong></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12" id="address_div">
                            <div class="profile_title">
                                <div class="col-md-12">
                                    <h2>Alamat {{ucfirst($role)}}
                                        @if(Auth::id() == $user->id)
                                            <span class="pull-right">
                                                <button class="btn btn-warning btn-sm" id="btn_editAddress">
                                                    <strong><i class="fa fa-edit"></i>&ensp;<span>EDIT</span></strong>
                                                </button>
                                            </span>
                                        @endif
                                    </h2>
                                </div>
                            </div>
                            <div id="map" class="height1" style="width:100%;"></div>
                            <div id="infowindow-content" style="display: none;">
                                <img src="{{$user->ava == "" || $user->ava == "avatar.png" ? asset('images/avatar.png')
                                : asset('storage/users/'.$user->ava)}}" width="32" height="32" id="place-icon">
                                <span id="place-name" class="title">{{$user->name}}</span><br>
                                <span id="place-address">{{$user->alamat}}</span>
                            </div>
                            <div id="address_setting" style="display: none">
                                <form method="post" action="{{route('update.profile')}}">
                                    {{csrf_field()}}
                                    {{method_field('PUT')}}
                                    <input type="hidden" name="check_form" value="address">
                                    <div class="row form-group">
                                        <div class="col-lg-12">
                                            <label for="address_map">Alamat Lengkap <span
                                                        class="required">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i
                                                            class="fa fa-map-marker-alt"></i></span>
                                                <textarea style="resize:vertical" name="alamat" id="address_map"
                                                          class="form-control" placeholder="Alamat lengkap"
                                                          required>{{$user->alamat}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-primary btn-block">
                                                <strong>SIMPAN PERUBAHAN</strong></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="avaModal">
        <div class="modal-dialog modal-lg">
            <img class="img-responsive" src="{{$user->ava == "" || $user->ava == "avatar.png" ?
            asset('images/avatar.png') : asset('storage/users/'.$user->ava)}}" style="margin: 0 auto;">
        </div>
    </div>
@endsection
@push("scripts")
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIljHbKjgtTrpZhEiHum734tF1tolxI68&libraries=places"></script>
    <script>
        var google;

        function init() {
            var myLatlng = new google.maps.LatLng('{{$user->lat}}', '{{$user->long}}');

            var mapOptions = {
                zoom: 16,
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

            var infowindow = new google.maps.InfoWindow();
            var infowindowContent = document.getElementById('infowindow-content');
            infowindow.setContent(infowindowContent);

            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                anchorPoint: new google.maps.Point(0, -29),
            });

            marker.addListener('click', function () {
                $("#infowindow-content").show();
                infowindow.open(map, marker);
            });

            google.maps.event.addListener(map, 'click', function () {
                $("#infowindow-content").hide();
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
                    infowindow.open(map, marker);
                });

                google.maps.event.addListener(map, 'click', function () {
                    infowindow.close();
                });
            });
        }

        google.maps.event.addDomListener(window, 'load', init);

        $("#btn_editPersonal").on('click', function () {
            $("#personal_settings").toggle(300).prev().toggle(300).prev().prev().toggle(300).prev().toggle(300);
            $(this).toggleClass('btn-warning btn-default');
            $("#btn_editPersonal i").toggleClass('fa-edit fa-undo-alt');
            $("#btn_editPersonal span").text(function (i, v) {
                return v === "EDIT" ? "BATAL" : "EDIT";
            });
        });

        $("#btn_editAddress").on('click', function () {
            $("#address_setting").toggle(300);
            $("#map").toggleClass('height1 height2');
            $(this).toggleClass('btn-warning btn-default');
            $("#btn_editAddress i").toggleClass('fa-edit fa-undo-alt');
            $("#btn_editAddress span").text(function (i, v) {
                return v === "EDIT" ? "BATAL" : "EDIT";
            });
        });

        function showAva() {
            $("#avaModal").modal('show');
        }

        document.getElementById("file-input").onchange = function () {
            var files_size = this.files[0].size,
                max_file_size = 2000000, allowed_file_types = ['image/png', 'image/gif', 'image/jpeg', 'image/pjpeg'],
                file_name = $(this).val().replace(/C:\\fakepath\\/i, ''),
                progress_bar_id = $("#progress-upload-ava .progress-bar");

            if (!window.File && window.FileReader && window.FileList && window.Blob) {
                swal('PERHATIAN!', "Browser yang Anda gunakan tidak support! Mohon perbarui atau gunakan browser yang lainnya.", 'warning');

            } else {
                if (files_size > max_file_size) {
                    swal('ERROR!', "Ukuran total " + file_name + " adalah " + humanFileSize(files_size) +
                        ", ukuran file yang diperbolehkan adalah " + humanFileSize(max_file_size) +
                        ", coba unggah file yang ukurannya lebih kecil!", 'error');

                } else {
                    $(this.files).each(function (i, ifile) {
                        if (ifile.value !== "") {
                            if (allowed_file_types.indexOf(ifile.type) === -1) {
                                swal('ERROR!', "Tipe file " + file_name + " tidak support!", 'error');
                            } else {
                                $.ajax({
                                    type: 'POST',
                                    url: '{{route('update.profile')}}',
                                    data: new FormData($("#form-ava")[0]),
                                    contentType: false,
                                    processData: false,
                                    mimeType: "multipart/form-data",
                                    xhr: function () {
                                        var xhr = $.ajaxSettings.xhr();
                                        if (xhr.upload) {
                                            xhr.upload.addEventListener('progress', function (event) {
                                                var percent = 0;
                                                var position = event.loaded || event.position;
                                                var total = event.total;
                                                if (event.lengthComputable) {
                                                    percent = Math.ceil(position / total * 100);
                                                }
                                                //update progressbar
                                                $("#progress-upload-ava").css("display", "block");
                                                progress_bar_id.css("width", +percent + "%");
                                                progress_bar_id.text(percent + "%");
                                                if (percent == 100) {
                                                    progress_bar_id.removeClass("progress-bar-danger");
                                                    progress_bar_id.addClass("progress-bar-success");
                                                } else {
                                                    progress_bar_id.removeClass("progress-bar-success");
                                                    progress_bar_id.addClass("progress-bar-danger");
                                                }
                                            }, true);
                                        }
                                        return xhr;
                                    },
                                    success: function (data) {
                                        $(".show_ava").attr('src', data);
                                        swal('SUKSES!', 'Foto profil berhasil diperbarui!', 'success');
                                        $("#progress-upload-ava").css("display", "none");
                                    },
                                    error: function () {
                                        swal('Oops...', 'Terjadi suatu kesalahan!', 'error');
                                    }
                                });
                                return false;
                            }
                        } else {
                            swal('Oops...', 'Tidak ada file yang dipilih!', 'error');
                        }
                    });
                }
            }
        };

        function humanFileSize(size) {
            var i = Math.floor(Math.log(size) / Math.log(1024));
            return (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
        };
    </script>
@endpush
