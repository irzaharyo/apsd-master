@extends('layouts.mst')
@section('title', 'Agenda Surat Masuk | '.env('APP_NAME').' - Aplikasi Pengarsipan Surat dan Disposisi | Dinas Pertanian dan Ketahanan Pangan Kota Madiun')
@push("styles")
    <link href="{{asset('css/myCheckbox.css')}}" rel="stylesheet">
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

        td ul, td ol {
            margin: 0 -2em;
        }
    </style>
@endpush
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Agenda Surat Masuk
                            <small id="panel_subtitle">List</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a id="btn_create" data-toggle="tooltip" title="Buat Agenda" data-placement="right">
                                    <i class="fa fa-plus"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" id="content1">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Detail Surat</th>
                                <th>Ringkasan / Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($agenda_masuks as $row)
                                @php
                                    $masuk = $row->getSuratDisposisi->getSuratMasuk;
                                    $lbr = $masuk->files != "" ? count($masuk->files) : 0;
                                    $index = substr($masuk->no_surat,4,3);
                                @endphp
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle">
                                        <table>
                                            <tr>
                                                <td><i class="fa fa-calendar-check"></i>&nbsp;</td>
                                                <td>Tanggal Penerimaan</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{\Carbon\Carbon::parse($masuk->created_at)->format('l, j F Y')}}</td>
                                            </tr>
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
                                        <a onclick='lihatSurat("{{$masuk->id}}", "masuk", "{{$lbr}}", "{{$index}}")'
                                           class="btn btn-info btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="{{'Lihat Surat ('.$lbr.' lembar)'}}" data-placement="left">
                                            <i class="fa fa-images"></i>
                                        </a>
                                        <hr style="margin: 5px auto">
                                        <a onclick='editAgenda("{{$row->id}}")' class="btn btn-warning btn-sm"
                                           style="font-size: 16px" data-toggle="tooltip" title="Edit Agenda"
                                           data-placement="left">
                                            <i class="fa fa-edit"></i></a>
                                        <hr style="margin: 5px auto">
                                        <a href="{{route('delete.agenda-masuk',['id' => encrypt($row->id)])}}"
                                           class="btn btn-danger btn-sm delete-agenda" style="font-size: 16px"
                                           data-toggle="tooltip" title="Hapus Agenda" data-placement="left">
                                            <i class="fa fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="x_content" id="content2" style="display: none">
                        <form method="post" action="{{route('create.agenda-masuk')}}" id="form-agm">
                            {{csrf_field()}}
                            <input type="hidden" name="_method">
                            <div class="row form-group" id="input-sm">
                                <div class="col-lg-12">
                                    <label for="surat_masuk">Surat Masuk</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                                        <select id="surat_masuk" class="form-control selectpicker"
                                                title="-- Pilih Surat Masuk --" data-live-search="true"
                                                name="surat_masuk" data-max-options="1" multiple required>
                                            @foreach($surat_masuks as $row)
                                                <option value="{{$row->id}}" {{\App\Models\AgendaMasuk::where
                                                ('suratdisposisi_id', $row->getSuratDisposisi->id)->count() > 0 ?
                                                'disabled' : ''}}><strong>{{$row->no_surat}}</strong>&nbsp;&mdash;
                                                    {{$row->nama_pengirim.' / '.$row->nama_instansi.', '.
                                                    $row->asal_instansi}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span style="color: #fa5555">NB: Anda hanya dapat memilih surat masuk yang agendanya belum dibuat.</span>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <label for="ringkasan">Ringkasan</label>
                                    <textarea id="ringkasan" class="use-tinymce" name="ringkasan"></textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <label for="keterangan">Keterangan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-sticky-note"></i></span>
                                        <textarea id="keterangan" class="form-control" name="keterangan"
                                                  placeholder="Tulis keterangan disini..." required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <button type="reset" class="btn btn-default btn-block" id="btn_agm_cancel">
                                        <strong>BATAL</strong></button>
                                </div>
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary btn-block" id="btn_agm_submit">
                                        <strong>SUBMIT</strong></button>
                                </div>
                            </div>
                        </form>
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
            @if($findSurat != "")
            $("#content1").toggle(300);
            $("#content2").toggle(300);
            $("#btn_create i").toggleClass('fa-plus fa-th-list');
            $("#btn_agm_submit").html("<strong>SUBMIT</strong>");
            $("#form-agm input[name=_method]").val('');
            $("#form-agm").attr('action', '{{route('create.agenda-masuk')}}');

            $("#btn_create[data-toggle=tooltip]").attr('data-original-title', function (i, v) {
                return v === "Buat Agenda" ? "Daftar Agenda" : "Buat Agenda";
            });

            $("#panel_subtitle").html(function (i, v) {
                return v === "Create Form" ? "List" : "Create Form";
            });
            $("#surat_masuk").val('{{$findSurat->id}}').selectpicker('refresh');
            @endif
        });

        var $indicators = '', $item = '';

        $("#btn_create, #btn_agm_cancel").on("click", function () {
            $("#content1").toggle(300);
            $("#content2").toggle(300);
            $("#btn_create i").toggleClass('fa-plus fa-th-list');
            $("#btn_agm_submit").html("<strong>SUBMIT</strong>");
            $("#form-agm input[name=_method]").val('');
            $("#form-agm").attr('action', '{{route('create.agenda-masuk')}}');

            $("#btn_create[data-toggle=tooltip]").attr('data-original-title', function (i, v) {
                return v === "Buat Agenda" ? "Daftar Agenda" : "Buat Agenda";
            });

            $("#panel_subtitle").html(function (i, v) {
                return v === "Create Form" ? "List" : "Create Form";
            });

            $("#input-sm").show();
            $("#surat_masuk").val('default').prop('required', true).selectpicker('refresh');
            $("#keterangan").val('');
            tinyMCE.get('ringkasan').setContent('');
        });

        $("#form-agm").on("submit", function (e) {
            e.preventDefault();
            if (tinyMCE.get('ringkasan').getContent() == "") {
                swal('PERHATIAN!', 'Kolom ringkasan harus diisi!', 'warning');
            } else {
                $(this)[0].submit();
            }
        });

        $(".delete-agenda").on("click", function () {
            var linkURL = $(this).attr("href");
            swal({
                title: 'Hapus Agenda Surat Masuk',
                text: 'Apakah Anda yakin? Anda tidak dapat mengembalikannya!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fa5555',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
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

        function editAgenda(id) {
            $("#content1").toggle(300);
            $("#content2").toggle(300);
            $("#btn_create i").toggleClass('fa-plus fa-th-list');
            $("#btn_agm_submit").html("<strong>SIMPAN PERUBAHAN</strong>");
            $("#form-agm input[name=_method]").val('PUT');
            $("#form-agm").attr('action', '{{route('update.agenda-masuk', ['id' => ''])}}/' + id);

            $("#btn_create[data-toggle=tooltip]").attr('data-original-title', function (i, v) {
                return v === "Buat Agenda" ? "Daftar Agenda" : "Buat Agenda";
            }).tooltip('show');

            $("#panel_subtitle").html(function (i, v) {
                return v === "Edit Form" ? "List" : "Edit Form";
            });

            $.get('{{route('edit.agenda-masuk', ['id' => ''])}}/' + id, function (data) {
                $("#input-sm").hide();
                $("#surat_masuk").prop('required', false).selectpicker('refresh');
                $("#keterangan").val(data.keterangan);
                tinyMCE.get('ringkasan').setContent(data.ringkasan);
            });
        }

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
                                'alt="file surat"></div>';
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
