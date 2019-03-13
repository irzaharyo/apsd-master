@extends('layouts.mst')
@section('title', 'Beranda | '.env('APP_NAME').' - Aplikasi Pengarsipan Surat dan Disposisi | Dinas Pertanian dan Ketahanan Pangan Kota Madiun')
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
        @if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->isRoot())
            <div class="row top_tiles">
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a href="javascript:void(0)" onclick="openTableUser()" class="agency">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-users"></i></div>
                            <div class="count">{{$newUser}}</div>
                            <h3>New {{$newUser > 1 ? 'Users' : 'User'}}</h3>
                            <p>Total: <strong>{{count($users)}}</strong> users</p>
                        </div>
                    </a>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a href="javascript:void(0)" onclick="openTableSuratMasuk()" class="seeker">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-envelope-open"></i></div>
                            <div class="count">{{$newSm}}</div>
                            <h3>Surat Masuk</h3>
                            <p>Total: <strong>{{count($masuks)}}</strong> surat masuk</p>
                        </div>
                    </a>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a href="javascript:void(0)" onclick="openTableSuratDisposisi()" class="agency">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-envelope"></i></div>
                            <div class="count">{{$newSd}}</div>
                            <h3>Surat Disposisi</h3>
                            <p>Total: <strong>{{count($disposisis)}}</strong> surat disposisi</p>
                        </div>
                    </a>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a href="javascript:void(0)" onclick="openTableSuratKeluar()" class="seeker">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-paper-plane"></i></div>
                            <div class="count">{{$newSk}}</div>
                            <h3>Surat Keluar</h3>
                            <p>Total: <strong>{{count($keluars)}}</strong> surat keluar</p>
                        </div>
                    </a>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Surat Masuk
                            <small>List</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Penerimaan</th>
                                <th>Detail Surat</th>
                                <th>Disposisi</th>
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
                                    $lbrSM = $masuk->files != "" ? count($masuk->files) : 0;
                                    $indexSM = substr($masuk->no_surat,4,3);
                                @endphp
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        {{\Carbon\Carbon::parse($masuk->created_at)->format('l, j F Y')}}</td>
                                    <td style="vertical-align: middle">
                                        <table>
                                            <tr>
                                                <td><i class="fa fa-hashtag"></i>&nbsp;</td>
                                                <td>Nomor Surat</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$masuk->no_surat}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-calendar-alt"></i>&nbsp;</td>
                                                <td>Tanggal Surat</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{\Carbon\Carbon::parse($masuk->tgl_surat)->format('j F Y')}}</td>
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
                                                <td><i class="fa fa-file-image"></i>&nbsp;</td>
                                                <td>Lampiran</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$masuk->lampiran}}</td>
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
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <span class="label label-{{$masuk->isDisposisi == true ? 'success' : 'danger'}}"
                                              style="text-transform: uppercase;font-size: 18px">
                                            <i class="fa fa-{{$masuk->isDisposisi == true ? 'check' : 'times'}}"></i>
                                        </span>
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <a onclick='lihatSurat("{{$masuk->id}}", "masuk", "{{$lbrSM}}", "{{$indexSM}}")'
                                           class="btn btn-dark btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="Lihat Surat ({{$lbrSM}} lembar)"
                                           data-placement="left"><i class="fa fa-images"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Surat Keluar
                            <small>List</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-fixed-header" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Detail Surat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($keluars as $keluar)
                                @php
                                    if($keluar->sifat_surat == 'rahasia'){
                                        $label = 'danger';
                                    } elseif($keluar->sifat_surat == 'sangat segera'){
                                        $label = 'primary';
                                    } elseif($keluar->sifat_surat == 'segera'){
                                        $label = 'info';
                                    } elseif($keluar->sifat_surat == 'penting'){
                                        $label = 'warning';
                                    } else {
                                        $label = 'default';
                                    }
                                    $lbrSK = $keluar->files != "" ? count($keluar->files) : 0;
                                    $indexSK = substr($keluar->no_surat,4,3);
                                @endphp
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        {{\Carbon\Carbon::parse($keluar->created_at)->format('l, j F Y')}}</td>
                                    <td style="vertical-align: middle">
                                        <table>
                                            <tr>
                                                <td><i class="fa fa-hashtag"></i>&nbsp;</td>
                                                <td>Nomor Surat</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$keluar->no_surat != null ? $keluar->no_surat : '(kosong)'}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-calendar-alt"></i>&nbsp;</td>
                                                <td>Tanggal Surat</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$keluar->tgl_surat != null ? \Carbon\Carbon::parse($keluar
                                                ->tgl_surat)->format('j F Y') : '(kosong)'}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-thumbtack"></i>&nbsp;</td>
                                                <td>Jenis Surat</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$keluar->getJenisSurat->jenis}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-user-tie"></i>&nbsp;</td>
                                                <td>Penerima</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$keluar->nama_penerima.' - '.$keluar->kota_penerima}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-comments"></i>&nbsp;</td>
                                                <td>Perihal</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$keluar->perihal != "" ? $keluar->perihal : '(kosong)'}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-file-image"></i>&nbsp;</td>
                                                <td>Lampiran</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$keluar->lampiran != "" ? $keluar->lampiran : '(kosong)'}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-tag"></i>&nbsp;</td>
                                                <td>Sifat Surat</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td style="text-transform: uppercase">
                                                    <span class="label label-{{$label}}">
                                                        {{$keluar->sifat_surat != null ? $keluar->sifat_surat : '(kosong)'}}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        @if($keluar->status == 0)
                                            <span class="label label-warning"
                                                  style="text-transform: uppercase">Diproses</span>
                                        @elseif($keluar->status == 1)
                                            <span class="label label-info" style="text-transform: uppercase">Menunggu Validasi</span>
                                        @elseif($keluar->status == 2)
                                            <span class="label label-primary"
                                                  style="text-transform: uppercase">Valid</span>
                                        @elseif($keluar->status == 3)
                                            <span class="label label-danger" style="text-transform: uppercase">Tidak Valid</span>
                                        @elseif($keluar->status == 4)
                                            <span class="label label-success" style="text-transform: uppercase">Surat Siap Diambil</span>
                                        @elseif($keluar->status == 5)
                                            <span class="label label-default" style="text-transform: uppercase">Surat Sudah Diambil</span>
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        @if($keluar->status == 0 || $keluar->status >= 4)
                                            <a onclick='lihatSurat("{{$keluar->id}}","keluar","{{$lbrSK}}", "{{$indexSK}}")'
                                               class="btn btn-dark btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                               title="Lihat Surat ({{$lbrSK}} lembar)" data-placement="left">
                                                <i class="fa fa-images"></i>
                                            </a>
                                        @else
                                            <a href="{{route('pdf.surat-keluar', ['id' => encrypt($keluar->id)])}}"
                                               target="_blank" class="btn btn-dark btn-sm" style="font-size: 16px"
                                               data-toggle="tooltip" title="Lihat Surat" data-placement="left">
                                                <i class="fa fa-file-pdf"></i>
                                            </a>
                                        @endif
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

        function lihatSurat(id, surat, total, index) {
            $indicators = '';
            $item = '';

            if (total > 0) {
                $.ajax({
                    url: "/surat-" + surat + "/" + id + "/files",
                    type: "GET",
                    success: function (data) {
                        $.each(data, function (i, val) {
                            var c = i + 1;
                            $indicators += '<li data-target="#lampiranModal" data-slide-to="' + i + '">' + c + '</li>';

                            $item += '<div class="item">' +
                                '<img src="{{asset('storage/surat-')}}' + surat + '/' + index + '/' + val + '" ' +
                                'alt="file surat"></div>'
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
                swal('PERHATIAN!', 'File surat tidak ditemukan.', 'warning')
            }
        }

        @if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->isRoot())
        function openTableUser() {
            window.location.href = '{{route('table.users')}}'
        }

        function openTableSuratMasuk() {
            window.location.href = '{{route('table.surat-masuk')}}'
        }

        function openTableSuratDisposisi() {
            window.location.href = '{{route('table.surat-disposisi')}}'
        }

        function openTableSuratKeluar() {
            window.location.href = '{{route('table.surat-keluar')}}'
        }
        @endif
    </script>
@endpush
