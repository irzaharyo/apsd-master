@extends('layouts.mst')
@php
    $title = 'Surat Masuk';
    if(Auth::guard('admin')->check()){
        $title = 'Surat Masuk dan Disposisi';
        $sm = '';
        $hr = '';
        $sd = '';
    } elseif(Auth::check()){
        if(Auth::user()->isKadin()){
            $title = 'Surat Masuk dan Disposisi';
            $sm = 'none';
            $hr = 'none';
            $sd = '';
        } elseif(Auth::user()->isPengolah()){
            $sm = '';
            $hr = 'none';
            $sd = 'none';
        }
    }
@endphp
@section('title', ''.$title.' | '.env('APP_NAME').' - Aplikasi Pengarsipan Surat dan Disposisi | Dinas Pertanian dan Ketahanan Pangan Kota Madiun')
@push("styles")
    <style>
        .dataTables_filter {
            /*width: 70%;*/
            width: auto;
        }

        .modal.and.carousel {
            position: fixed;
        }

        .carousel-indicators-numbers li {
            text-indent: 0;
            margin: 0 2px;
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 100%;
            line-height: 30px;
            color: #fff;
            background-color: #999;
            transition: all 0.25s ease;
        }

        .carousel-indicators-numbers li.active, .carousel-indicators-numbers li:hover {
            margin: 0 2px;
            width: 30px;
            height: 30px;
            background-color: #2A3F54;
        }
    </style>
@endpush
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{$title}}
                            <small>List</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            @if(Auth::guard('admin')->check() || Auth::user()->isPengolah())
                                <li data-toggle="tooltip" title="Tambah Surat"><a onclick="tambahSurat()">
                                        <i class="fa fa-plus"></i></a></li>
                            @endif
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-fixed-header" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Detail Surat</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($masuks as $masuk)
                                @php
                                    if($masuk->sifat_surat == 'rahasia'){
                                        $label = 'danger';
                                    } elseif($masuk->sifat_surat == 'sangat segera'){
                                        $label = 'primary';
                                    } elseif($masuk->sifat_surat == 'segera'){
                                        $label = 'info';
                                    } elseif($masuk->sifat_surat == 'penting'){
                                        $label = 'warning';
                                    } else {
                                        $label = 'default';
                                    }
                                @endphp
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle">
                                        <table>
                                            <tr>
                                                <td><i class="fa fa-calendar-alt"></i>&nbsp;</td>
                                                <td>Tanggal Surat</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$masuk->tgl_surat}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-hashtag"></i>&nbsp;</td>
                                                <td>Nomor Surat</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$masuk->no_surat}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-thumbtack"></i>&nbsp;</td>
                                                <td>Jenis Surat</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$masuk->getJenisSurat->jenis}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-user-tie"></i>&nbsp;</td>
                                                <td>Nama Pengirim</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$masuk->nama_pengirim}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-university"></i>&nbsp;</td>
                                                <td>Instansi Pengirim</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$masuk->nama_instansi.' - '.$masuk->asal_instansi}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-comments"></i>&nbsp;</td>
                                                <td>Perihal</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$masuk->perihal}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-tag"></i>&nbsp;</td>
                                                <td>Sifat Surat</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td style="text-transform: uppercase">
                                                    <span class="label label-{{$label}}">{{$masuk->sifat_surat}}</span>
                                                </td>
                                            </tr>
                                        </table>
                                        <hr style="margin: .5em 0">
                                        <strong>Disposisi :</strong>
                                        @if($masuk->isDisposisi == true)
                                            <table>
                                                <tr data-toggle="tooltip" data-placement="left"
                                                    title="Diteruskan Kepada">
                                                    <td><i class="fa fa-user-tie"></i>&nbsp;</td>
                                                    <td>{{$masuk->getSuratDisposisi->diteruskan_kepada}}</td>
                                                </tr>
                                                <tr data-toggle="tooltip" data-placement="left" title="Harapan">
                                                    <td><i class="fa fa-hand-holding"></i>&nbsp;</td>
                                                    <td>{{$masuk->getSuratDisposisi->harapan}}</td>
                                                </tr>
                                                <tr data-toggle="tooltip" data-placement="left" title="Catatan">
                                                    <td><i class="fa fa-clipboard-list"></i>&nbsp;</td>
                                                    <td>{{$masuk->getSuratDisposisi->catatan}}</td>
                                                </tr>
                                            </table>
                                        @else
                                            (kosong)
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <div class="btn-group" style="display: {{$sm}}">
                                            <button onclick='editSuratMasuk("{{$masuk->id}}")'
                                                    type="button" class="btn btn-warning btn-sm"
                                                    style="font-weight: 600">
                                                <i class="fa fa-edit"></i>&ensp;EDIT SURAT
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a onclick='lihatLampiran("{{$masuk->id}}","masuk",
                                                            "{{filter_var($masuk->lampiran,FILTER_SANITIZE_NUMBER_INT)}}")'>
                                                        <i class="fa fa-images"></i>&ensp;{{'Lihat Lampiran ('.filter_var($masuk->lampiran,
                                                        FILTER_SANITIZE_NUMBER_INT).' lembar)'}}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{route('delete.surat-masuk',['id' =>
                                                    encrypt($masuk->id)])}}" class="delete-surat">
                                                        <i class="fa fa-trash"></i>&ensp;Hapus Surat
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <hr style="margin: .5em 0;display: {{$hr}}">
                                        <div class="btn-group" style="display: {{$sd}}">
                                            <button type="button" class="btn btn-success btn-sm"
                                                    style="font-weight: 600" onclick="disposisi('{{$masuk->id}}')"
                                                    {{$masuk->isDisposisi == false ? '' : 'disabled'}}>
                                                <i class="fa fa-envelope"></i>&ensp;{{$masuk->isDisposisi == false ? 'DISPOSISI' : 'TERDISPOSISI'}}
                                            </button>
                                            <button type="button" class="btn btn-success btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                @if($masuk->isDisposisi == true)
                                                    <li>
                                                        <a onclick="editDisposisi('{{$masuk->getSuratDisposisi->id}}')">
                                                            <i class="fa fa-edit"></i>&ensp;Edit Surat Disposisi</a>
                                                    </li>
                                                @endif
                                                <li>
                                                    <a onclick='lihatLampiran("{{$masuk->id}}","masuk",
                                                            "{{filter_var($masuk->lampiran,FILTER_SANITIZE_NUMBER_INT)}}")'>
                                                        <i class="fa fa-images"></i>&ensp;{{'Lihat Lampiran ('.filter_var($masuk->lampiran,
                                                        FILTER_SANITIZE_NUMBER_INT).' lembar)'}}
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
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade and carousel slide" id="lampiranModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <ol class="carousel-indicators carousel-indicators-numbers"></ol>
                    <div class="carousel-inner"></div>
                    <a class="left carousel-control" href="#lampiranModal" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#lampiranModal" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script>
        var $indicators = '', $item = '';

        function lihatLampiran(id, surat, total) {
            $indicators = '';
            $item = '';

            if (total > 0) {
                $.ajax({
                    url: "/surat-" + surat + "/" + id + "/lampiran",
                    type: "GET",
                    success: function (data) {
                        $.each(data, function (i, val) {
                            var c = i + 1;
                            $indicators += '<li data-target="#lampiranModal" data-slide-to="' + i + '">' + c + '</li>';

                            $item += '<div class="item">' +
                                '<img src="{{asset('storage/lampiran/surat-')}}' + surat + '/' + val + '" alt="Lampiran">' +
                                '</div>'
                        });
                        $("#lampiranModal .carousel-indicators").html($indicators);
                        $("#lampiranModal .carousel-inner").html($item);

                        $('.carousel-indicators').find('li').first().addClass('active');
                        $('.carousel-inner').find('.item').first().addClass('active');
                        $("#lampiranModal").modal('show');
                    },
                    error: function () {
                        swal({
                            title: 'Oops..',
                            text: 'Terjadi kesalahan! Mohon refresh halaman ini.',
                            type: 'error',
                            timer: '1500'
                        })
                    }
                });
            } else {
                swal('PERHATIAN!', 'Tidak ada lampiran.', 'warning')
            }
        }

        $(".delete-surat").on("click", function () {
            var linkURL = $(this).attr("href");
            swal({
                title: 'Hapus Surat Masuk',
                text: 'Apakah Anda yakin? Anda tidak dapat mengembalikannya!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fa5555',
                confirmButtonText: 'Ya, hapus surat ini!',
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return new Promise(function (resolve) {
                        window.location.href = linkURL;
                    });
                },
                allowOutsideClick: false
            });
            return false;
        });
    </script>
@endpush
