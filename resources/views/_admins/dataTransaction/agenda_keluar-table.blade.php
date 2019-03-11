@extends('layouts.mst')
@section('title', 'Halaman Admin: Tabel Agenda Surat Keluar | '.env('APP_NAME').' - Aplikasi Pengarsipan Surat dan Disposisi | Dinas Pertanian dan Ketahanan Pangan Kota Madiun')
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
                        <h2 id="panel_title">Agenda Surat Keluar
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
                                        <option value="{{$row->no_surat}}"><strong>{{$row->no_surat}}</strong>&nbsp;&mdash;
                                            {{$row->nama_pengirim.' / '.$row->nama_instansi.', '.
                                            $row->asal_instansi}}</option>
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
                                <th>Detail Surat</th>
                                <th>Ringkasan / Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($ag_keluars as $row)
                                @php
                                    $keluar = $row->getSuratKeluar;
                                    $lbrSK = $keluar->files != "" ? count($keluar->files) : 0;
                                    $indexSK = substr($keluar->no_surat,4,3);
                                @endphp
                                <tr>
                                    <td class="a-center" style="vertical-align: middle" align="center">
                                        <input type="checkbox" class="flat">
                                    </td>
                                    <td style="vertical-align: middle">{{$row->id}}</td>
                                    <td style="vertical-align: middle">
                                        <table>
                                            <tr>
                                                <td><i class="fa fa-calendar-check"></i>&nbsp;</td>
                                                <td>Tanggal Pengajuan</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{\Carbon\Carbon::parse($keluar->created_at)->format('l, j F Y')}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-hashtag"></i>&nbsp;</td>
                                                <td>Nomor Surat</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$keluar->no_surat}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-calendar-alt"></i>&nbsp;</td>
                                                <td>Tanggal Surat</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{\Carbon\Carbon::parse($keluar->tgl_surat)->format('j F Y')}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-user-tie"></i>&nbsp;</td>
                                                <td>Penerima</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{$keluar->nama_penerima.' - '.$keluar->kota_penerima}}</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="vertical-align: middle">
                                        <strong>Ringkasan:</strong>
                                        {!! $row->ringkasan !!}
                                        <hr style="margin: .5em 0">
                                        <strong>Keterangan:</strong><br>
                                        {{$row->keterangan}}
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <a onclick='lihatSurat("{{$keluar->id}}", "keluar", "{{$lbrSK}}", "{{$indexSK}}")'
                                           class="btn btn-dark btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="Lihat Surat ({{$lbrSK}} lembar)"
                                           data-placement="left"><i class="fa fa-images"></i>
                                        </a>
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
                            <form method="post" id="form-agk">
                                {{csrf_field()}}
                                <input id="agk_ids" type="hidden" name="agk_ids">
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
                                $.get("{{route('massPDF.agenda-keluar', ['ids' => ''])}}/" + ids, function (data) {
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
                $("#agk_ids").val(ids);
                $("#form-agk").attr("action", "{{route('massDelete.agenda-keluar')}}");

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
                                $("#form-agk")[0].submit();
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
    </script>
@endpush