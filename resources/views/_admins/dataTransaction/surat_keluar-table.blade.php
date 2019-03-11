@extends('layouts.mst')
@section('title', 'Halaman Admin: Tabel Surat Keluar | '.env('APP_NAME').' - Aplikasi Pengarsipan Surat dan Disposisi | Dinas Pertanian dan Ketahanan Pangan Kota Madiun')
@push("styles")
    <style>
        td ul, td ol {
            margin: 0 -2em;
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
                        <h2 id="panel_title">Surat Keluar
                            <small>Table</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="close-link" data-toggle="tooltip" title="Close" data-placement="right">
                                    <i class="fa fa-times"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div id="content1" class="x_content">
                        <div class="row form-group">
                            <div class="col-lg-12 has-feedback">
                                <label for="surat_keluar">Filter Surat</label>
                                <select id="surat_keluar" class="form-control selectpicker"
                                        title="-- Pilih Surat Keluar --" data-live-search="true"
                                        name="surat_keluar" data-max-options="1" multiple required>
                                    @foreach($keluars as $row)
                                        <option value="{{$row->id}}">
                                            <strong>{{$row->no_surat}}</strong>&nbsp;&mdash;&nbsp;{{$row->nama_penerima.', '.
                                            $row->kota_penerima}}</option>
                                    @endforeach
                                </select>
                                <span class="fa fa-envelope-open form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
                        <table id="myDataTable" class="table table-striped table-bordered bulk_action">
                            <thead>
                            <tr>
                                <th><input type="checkbox" id="check-all" class="flat"></th>
                                <th>ID</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Detail Surat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>

                            <tbody>
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
                                    <td class="a-center" style="vertical-align: middle" align="center">
                                        <input type="checkbox" class="flat">
                                    </td>
                                    <td style="vertical-align: middle">{{$keluar->id}}</td>
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
                                            <a href="{{route('show.pdfSuratKeluar', ['id' => encrypt($keluar->id)])}}"
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
                        <div class="row form-group">
                            <div class="col-sm-4" id="action-btn">
                                <div class="btn-group" style="float: right">
                                    <button id="btn_pdf" type="button" class="btn btn-primary btn-sm"
                                            style="font-weight: 600">
                                        <i class="fa fa-file-pdf"></i>&ensp;PDF
                                    </button>
                                    <button id="btn_remove_app" type="button" class="btn btn-danger btn-sm"
                                            style="font-weight: 600">
                                        <i class="fa fa-trash"></i>&ensp;HAPUS
                                    </button>
                                </div>
                            </div>
                            <form method="post" id="form-sk">
                                {{csrf_field()}}
                                <input id="sk_ids" type="hidden" name="sk_ids">
                            </form>
                        </div>
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

        $(function () {
            var table = $("#myDataTable").DataTable({
                order: [[1, "desc"]],
                columnDefs: [
                    {
                        targets: [0],
                        orderable: false
                    },
                    {
                        targets: [1],
                        visible: false,
                        searchable: false
                    }
                ]
            }), toolbar = $("#myDataTable_wrapper").children().eq(0);

            toolbar.children().toggleClass("col-sm-6 col-sm-4");
            $('#action-btn').appendTo(toolbar);

            $("#surat_keluar").on('change', function () {
                $(".dataTables_filter input[type=search]").val($(this).val()).trigger('keyup');
            });

            $("#check-all").on("ifToggled", function () {
                if ($(this).is(":checked")) {
                    $("#myDataTable tbody tr").addClass("selected").find('input[type=checkbox]').iCheck("check");
                } else {
                    $("#myDataTable tbody tr").removeClass("selected").find('input[type=checkbox]').iCheck("uncheck");
                }
            });

            $("#myDataTable tbody").on("click", "tr", function () {
                $(this).toggleClass("selected");
                $(this).find('input[type=checkbox]').iCheck("toggle");
            });

            $('#btn_pdf').on("click", function () {
                var ids = $.map(table.rows('.selected').data(), function (item) {
                    return item[1]
                });

                if (ids.length > 0) {
                    swal({
                        title: 'Generate PDF',
                        text: 'Apakah Anda yakin men-generate ' + ids.length + ' data tersebut ke dalam sebuah file pdf? ' +
                            'Anda tidak dapat mengembalikannya!',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#00adb5',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Tidak',
                        showLoaderOnConfirm: true,

                        preConfirm: function () {
                            return new Promise(function (resolve) {
                                $.get("{{route('massPDF.surat-keluar', ['ids' => ''])}}/" + ids, function (data) {
                                    swal("Success!", "File PDF berhasil di-generate!", "success");
                                });
                            });
                        },
                        allowOutsideClick: false
                    });
                } else {
                    swal("Error!", "Tidak ada data yang dipilih!", "error");
                }
                return false;
            });

            $('#btn_remove_app').on("click", function () {
                var ids = $.map(table.rows('.selected').data(), function (item) {
                    return item[1]
                });
                $("#sk_ids").val(ids);
                $("#form-sk").attr("action", "{{route('massDelete.surat-keluar')}}");

                if (ids.length > 0) {
                    swal({
                        title: 'Hapus Surat Keluar',
                        text: 'Apakah Anda yakin menghapus ' + ids.length + ' data tersebut? Anda tidak dapat mengembalikannya!',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#fa5555',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Tidak',
                        showLoaderOnConfirm: true,

                        preConfirm: function () {
                            return new Promise(function (resolve) {
                                $("#form-sk")[0].submit();
                            });
                        },
                        allowOutsideClick: false
                    });
                } else {
                    swal("Error!", "Tidak ada file yang dipilih!", "error");
                }
                return false;
            });
        });

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
    </script>
@endpush