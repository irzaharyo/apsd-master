@extends('layouts.mst')
@section('title', 'Agenda Surat Keluar | '.env('APP_NAME').' - Aplikasi Pengarsipan Surat dan Disposisi | Dinas Pertanian dan Ketahanan Pangan Kota Madiun')
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
                        <h2>Agenda Surat Keluar
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
                            @foreach($agenda_keluars as $row)
                                @php
                                    $keluar = $row->getSuratKeluar;
                                    $lbr = $keluar->files != "" ? count($keluar->files) : 0;
                                    $index = substr($keluar->no_surat,4,3);
                                @endphp
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
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
                                        @if($keluar->status == 0 || $keluar->status >= 4)
                                            <a onclick='lihatSurat("{{$keluar->id}}", "keluar", "{{$lbr}}", "{{$index}}")'
                                               class="btn btn-info btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                               title="{{'Lihat Surat ('.$lbr.' lembar)'}}" data-placement="left">
                                                <i class="fa fa-images"></i>
                                            </a>
                                        @else
                                            <a href="{{asset('storage/surat-keluar/'.$index.'/SuratKeluar.pdf')}}"
                                               target="_blank" class="btn btn-info btn-sm" style="font-size: 16px"
                                               data-toggle="tooltip" title="Lihat Surat" data-placement="left">
                                                <i class="fa fa-file-pdf"></i>
                                            </a>
                                        @endif
                                        <hr style="margin: 5px auto">
                                        <a onclick='editAgenda("{{$row->id}}")' class="btn btn-warning btn-sm"
                                           style="font-size: 16px" data-toggle="tooltip" title="Edit Agenda"
                                           data-placement="left">
                                            <i class="fa fa-edit"></i></a>
                                        <hr style="margin: 5px auto">
                                        <a href="{{route('delete.agenda-keluar',['id' => encrypt($row->id)])}}"
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
                        <form method="post" action="{{route('create.agenda-keluar')}}" id="form-agm"
                              enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="_method">
                            <div class="row form-group" id="input-sk">
                                <div class="col-lg-12">
                                    <label for="surat_keluar">Surat Keluar</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                                        <select id="surat_keluar" class="form-control selectpicker"
                                                title="-- Pilih Surat Keluar --" data-live-search="true"
                                                name="surat_keluar" data-max-options="1" multiple required>
                                            @foreach($surat_keluars as $row)
                                                <option value="{{$row->id}}" {{\App\Models\AgendaKeluar::where
                                                ('suratkeluar_id', $row->id)->count() > 0 ? 'disabled' : ''}}>
                                                    <strong>{{$row->no_surat}}</strong>&nbsp;&mdash;&nbsp;{{$row
                                                    ->nama_penerima.', '.$row->kota_penerima}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span style="color: #fa5555">NB: Anda hanya dapat memilih surat keluar yang agendanya belum dibuat.</span>
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
                                                  placeholder="Tulis keterangan disini..." required
                                                  style="resize: vertical"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <label for="files">Unggah File Surat <span class="required">*</span></label>
                                    <input type="file" name="files[]" style="display: none;" accept="image/*"
                                           id="attach-files" multiple>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-images"></i></span>
                                        <input type="text" id="txt_attach" class="browse_files form-control"
                                               placeholder="Unggah file disini..." readonly style="cursor: pointer"
                                               data-toggle="tooltip" data-placement="top"
                                               title="Ekstensi file yang boleh diunggah: jpg, jpeg, gif, png. Ukuran file maksimal: < 5 MB">
                                        <span class="input-group-btn">
                                            <button class="browse_files btn btn-dark" type="button">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                    <span class="help-block">
                                        <small id="count_files"></small>
                                    </span>
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
            <div class="card">
                <div class="img-card">
                    <div id="carousel-example" class="carousel slide carousel-fullscreen" data-ride="carousel">
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
                <div class="card-content">
                    <div class="card-title">
                        <small>File Surat Keluar <span onclick="showDeleteFiles()" class="pull-right"
                                                       style="cursor: pointer;color: #2A3F54">
                                <i class="fa fa-edit"></i>&ensp;EDIT</span></small>
                        <hr style="margin: .5em 0">
                        <div id="delete-files" style="display: none"></div>
                    </div>
                </div>
                <div class="card-read-more" id="btn_delete_fileSurat">
                    <button class="btn btn-link btn-block" data-placement="top" data-toggle="tooltip" disabled
                            title="Klik disini untuk menghapus semua file yang Anda pilih!">
                        <i class="fa fa-trash"></i>&nbsp;HAPUS FILE
                    </button>
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
            $("#form-agm").attr('action', '{{route('create.agenda-keluar')}}');

            $("#btn_create[data-toggle=tooltip]").attr('data-original-title', function (i, v) {
                return v === "Buat Agenda" ? "Daftar Agenda" : "Buat Agenda";
            });

            $("#panel_subtitle").html(function (i, v) {
                return v === "Create Form" ? "List" : "Create Form";
            });
            $("#surat_keluar").val('{{$findSurat->id}}').selectpicker('refresh');
            @endif
        });

        var $indicators = '', $item = '', $deleteFiles = '',
            text_truncate = function (str, length, ending) {
                if (length == null) {
                    length = 100;
                }
                if (ending == null) {
                    ending = '...';
                }
                if (str.length > length) {
                    return str.substring(0, length - ending.length) + ending;
                } else {
                    return str;
                }
            };

        $("#btn_create, #btn_agm_cancel").on("click", function () {
            $("#content1").toggle(300);
            $("#content2").toggle(300);
            $("#btn_create i").toggleClass('fa-plus fa-th-list');
            $("#btn_agm_submit").html("<strong>SUBMIT</strong>");
            $("#form-agm input[name=_method]").val('');
            $("#form-agm").attr('action', '{{route('create.agenda-keluar')}}');

            $("#btn_create[data-toggle=tooltip]").attr('data-original-title', function (i, v) {
                return v === "Buat Agenda" ? "Daftar Agenda" : "Buat Agenda";
            });

            $("#panel_subtitle").html(function (i, v) {
                return v === "Create Form" ? "List" : "Create Form";
            });

            $("#input-sk").show();
            $("#surat_keluar").val('default').prop('required', true).selectpicker('refresh');
            $("#keterangan").val('');
            tinyMCE.get('ringkasan').setContent('');

            $("#attach-files").val('');
            $("#txt_attach").val('');
            $("#count_files").text('');
            $("#txt_attach[data-toggle=tooltip]").attr('data-original-title', 'Ekstensi file yang boleh diunggah: jpg, jpeg, gif, png. Ukuran file maksimal: < 5 MB');
        });

        $(".browse_files").on('click', function () {
            $("#attach-files").trigger('click');
        });
        $("#attach-files").on('change', function () {
            var files = $(this).prop("files");
            var count = $(this).get(0).files.length;
            var names = $.map(files, function (val) {
                return val.name;
            });
            var txt = $("#txt_attach");
            txt.val(names);
            $("#txt_attach[data-toggle=tooltip]").attr('data-original-title', names).tooltip('show');
            if (count > 1) {
                $("#count_files").text(count + " file terpilih");
            } else {
                $("#count_files").text(count + " file terpilih");
            }
        });

        $("#form-agm").on("submit", function (e) {
            e.preventDefault();
            if (tinyMCE.get('ringkasan').getContent() == "") {
                swal('PERHATIAN!', 'Kolom ringkasan harus diisi!', 'warning');
            } else if ($("#attach-files").get(0).files.length === 0 && !$("#form-agm input[name=_method]").val()) {
                swal('PERHATIAN!', 'Anda belum mengunggah file surat keluar!', 'warning');
            } else {
                $(this)[0].submit();
            }
        });

        $(".delete-agenda").on("click", function () {
            var linkURL = $(this).attr("href");
            swal({
                title: 'Hapus Agenda Surat Keluar',
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
            $("#form-agm").attr('action', '{{route('update.agenda-keluar', ['id' => ''])}}/' + id);

            $("#btn_create[data-toggle=tooltip]").attr('data-original-title', function (i, v) {
                return v === "Buat Agenda" ? "Daftar Agenda" : "Buat Agenda";
            }).tooltip('show');

            $("#panel_subtitle").html(function (i, v) {
                return v === "Edit Form" ? "List" : "Edit Form";
            });

            $("#attach-files").val('');
            $("#txt_attach").val('');
            $("#count_files").text('');
            $("#txt_attach[data-toggle=tooltip]").attr('data-original-title', 'Ekstensi file yang boleh diunggah: jpg, jpeg, gif, png. Ukuran file maksimal: < 5 MB');

            $.get('{{route('edit.agenda-keluar', ['id' => ''])}}/' + id, function (data) {
                $("#input-sk").hide();
                $("#surat_keluar").prop('required', false).selectpicker('refresh');
                $("#keterangan").val(data.keterangan);
                tinyMCE.get('ringkasan').setContent(data.ringkasan);
            });
        }

        function lihatSurat(id, surat, total, index) {
            $indicators = '';
            $item = '';
            $deleteFiles = '';

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

                            $deleteFiles += '<li><input type="checkbox" name="fileSuratKeluars[]" ' +
                                'class="fileSurat_cb" value="' + val + '">' + text_truncate(val, 25) + '</li>';
                        });
                        $("#lampiranModal .carousel-indicators").html($indicators);
                        $("#lampiranModal .carousel-inner").html($item);

                        $("#delete-files").html(
                            '<form action="{{route('massDelete.surat-keluar',['id' => ''])}}/' + id + '" ' +
                            'id="form-delete-files">' +
                            '<ul class="myCheckbox" id="fileSurat_ul">' +
                            '<li><input type="checkbox" class="fileSurat_cb" id="selectAll">' +
                            'Pilih ' + data.length + ' file</li>' +
                            '<div id="fileSurat_li"></div></ul></form>'
                        );
                        $("#fileSurat_li").html($deleteFiles);

                        $('.carousel-indicators').find('li').first().addClass('active');
                        $('.carousel-inner').find('.item').first().addClass('active');
                        $("#lampiranModal").modal('show');

                        var $fileSurat_cb = $(".fileSurat_cb"), $selectAll = $("#selectAll"),
                            $btnDelete = $("#btn_delete_fileSurat button");

                        $selectAll.click(function () {
                            $('.fileSurat_cb').prop('checked', this.checked);
                        });
                        $fileSurat_cb.click(function () {
                            if ($(".fileSurat_cb").length === $(".fileSurat_cb:checked").length) {
                                $("#selectAll").prop('checked', true);
                            } else {
                                $("#selectAll").prop('checked', false);
                            }
                        });
                        $fileSurat_cb.change(function () {
                            if ($(this).is(":checked")) {
                                $btnDelete.removeAttr('disabled');
                                $(this).closest('li').addClass("active");
                            } else {
                                $(this).closest('li').removeClass("active");
                                $btnDelete.attr('disabled', true);
                            }
                        });
                        $selectAll.change(function () {
                            if ($(this).is(":checked")) {
                                $btnDelete.removeAttr('disabled');
                                $("#fileSurat_list li").addClass("active");
                            } else {
                                $("#fileSurat_list li").removeClass("active");
                                $btnDelete.attr('disabled', true);
                            }
                        });
                        $btnDelete.on('click', function () {
                            swal({
                                title: 'Hapus File Surat Keluar',
                                text: 'Apakah Anda yakin? Anda tidak dapat mengembalikannya!',
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#fa5555',
                                confirmButtonText: 'Ya',
                                cancelButtonText: 'Tidak',
                                showLoaderOnConfirm: true,

                                preConfirm: function () {
                                    return new Promise(function (resolve) {
                                        $("#form-delete-files")[0].submit();
                                    });
                                },
                                allowOutsideClick: false
                            });
                            return false;
                        });
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

        function showDeleteFiles() {
            $("#delete-files").toggle(300);
        }
    </script>
@endpush
