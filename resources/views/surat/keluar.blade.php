@extends('layouts.mst')
@section('title', 'Surat Keluar | '.env('APP_NAME').' - Aplikasi Pengarsipan Surat dan Disposisi | Dinas Pertanian dan Ketahanan Pangan Kota Madiun')
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
                                <th>Tanggal Surat</th>
                                <th>Nomor Surat</th>
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
                                    $lampiran = filter_var($keluar->lampiran, FILTER_SANITIZE_NUMBER_INT) > 0 ?
                                    filter_var($keluar->lampiran, FILTER_SANITIZE_NUMBER_INT) : 0;
                                @endphp
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle" align="center">{{$keluar->tgl_surat != null ?
                                    $keluar->tgl_surat : '(kosong)'}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        <strong>{{$keluar->no_surat != null ? $keluar->no_surat : '(kosong)'}}</strong>
                                    </td>
                                    <td style="vertical-align: middle">
                                        <table>
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
                                                <td>{{$keluar->perihal}}</td>
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
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <a onclick='lihatLampiran("{{$keluar->id}}","keluar","{{$lampiran}}")'
                                           class="btn btn-dark btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="{{$lampiran}} lampiran" data-placement="left"><i
                                                    class="fa fa-images"></i>
                                        </a>
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
    </script>
@endpush
