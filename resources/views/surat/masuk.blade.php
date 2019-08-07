@extends('layouts.mst')
@section('title', 'Surat Masuk | '.env('APP_NAME').' - Aplikasi Pengarsipan Surat dan Disposisi | Dinas Pertanian dan Ketahanan Pangan Kota Madiun')
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
                        <h2>Surat Masuk
                            <small id="panel_subtitle">List</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            @if(Auth::user()->isPengolah())
                                <li><a id="btn_create" data-toggle="tooltip" title="Buat Surat"
                                       data-placement="right"><i class="fa fa-plus"></i></a></li>
                            @endif
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" id="content1">
                        <table id="datatable-responsive" class="table table-striped table-bordered">
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
                                                <td>{{\Carbon\Carbon::parse($masuk->created_at)->format('l, j F Y - h:i:s')}}</td>
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
                                        <hr style="margin: .5em 0">
                                        <strong>Disposisi :</strong>
                                        @if($masuk->isDisposisi == true)
                                            <table>
                                                <tr data-toggle="tooltip" data-placement="left"
                                                    title="Diteruskan kepada Sdr.">
                                                    <td><i class="fa fa-user-tie"></i>&nbsp;</td>
                                                    <td>{!!$masuk->getSuratDisposisi->diteruskan_kepada!!}</td>
                                                </tr>
                                                <tr data-toggle="tooltip" data-placement="left"
                                                    title="Dengan hormat harap">
                                                    <td><i class="fa fa-hand-holding"></i>&nbsp;</td>
                                                    <td>{{$masuk->getSuratDisposisi->harapan}}</td>
                                                </tr>
                                                <tr data-toggle="tooltip" data-placement="left" title="Catatan">
                                                    <td><i class="fa fa-clipboard-list"></i>&nbsp;</td>
                                                    <td>{{$masuk->getSuratDisposisi->catatan != "" ?
                                                    $masuk->getSuratDisposisi->catatan : '(kosong)'}}</td>
                                                </tr>
                                            </table>
                                        @else
                                            (kosong)
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        @if(Auth::user()->isPengolah())
                                            <div class="btn-group">
                                                <button onclick='editSuratMasuk("{{$masuk->id}}")'
                                                        type="button" class="btn btn-warning btn-sm"
                                                        style="font-weight: 600" {{$masuk->isDisposisi == true ? 'disabled' : ''}}>
                                                    <i class="fa fa-edit"></i>&ensp;EDIT
                                                </button>
                                                <button type="button" class="btn btn-warning btn-sm dropdown-toggle"
                                                        data-toggle="dropdown" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                        <a onclick='lihatSurat("{{$masuk->id}}", "masuk", "{{$lbr}}", "{{$index}}")'>
                                                            <i class="fa fa-images"></i>&ensp;{{'Lihat Surat ('.$lbr.' lembar)'}}
                                                        </a>
                                                    </li>
                                                    @if($masuk->isDisposisi == false)
                                                        <li>
                                                            <a href="{{route('delete.surat-masuk',['id' => encrypt
                                                            ($masuk->id)])}}" class="delete-surat" data-surat="masuk">
                                                                <i class="fa fa-trash"></i>&ensp;Hapus Surat
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @elseif(Auth::user()->isKadin())
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-success btn-sm"
                                                        style="font-weight: 600"
                                                        onclick="disposisiSurat('{{$masuk->id}}',
                                                                '{{$masuk->no_surat}}','create')"
                                                        {{$masuk->isDisposisi == false ? '' : 'disabled'}}>
                                                    <i class="fa fa-envelope"></i>&ensp;{{$masuk->isDisposisi == false ?
                                                'DISPOSISI' : 'TERDISPOSISI'}}
                                                </button>
                                                <button type="button" class="btn btn-success btn-sm dropdown-toggle"
                                                        data-toggle="dropdown" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                        <a onclick='lihatSurat("{{$masuk->id}}", "masuk", "{{$lbr}}", "{{$index}}")'>
                                                            <i class="fa fa-images"></i>&ensp;{{'Lihat Surat ('.$lbr.' lembar)'}}
                                                        </a>
                                                    </li>
                                                    @if($masuk->isDisposisi == true)
                                                        <li>
                                                            <a onclick="disposisiSurat('{{$masuk->getSuratDisposisi->id}}',
                                                                    '{{$masuk->no_surat}}','update')">
                                                                <i class="fa fa-edit"></i>&ensp;Edit Surat Disposisi</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{route('delete.surat-disposisi',['id' => encrypt
                                                            ($masuk->getSuratDisposisi->id)])}}" data-surat="disposisi"
                                                               class="delete-surat">
                                                                <i class="fa fa-trash"></i>&ensp;Hapus Surat
                                                                Disposisi</a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="x_content" id="content2" style="display: none">
                        <form method="post" action="{{route('create.surat-masuk')}}" id="form-sm"
                              enctype="multipart/form-data">{{csrf_field()}}
                            <input type="hidden" name="_method">
                            <div class="row form-group">
                                <div class="col-lg-7">
                                    <label for="no_surat">Nomor Surat <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                                        <input id="no_surat" class="form-control" type="text" name="no_surat"
                                               placeholder="kode_perihal/nomor_urut/kode_instansi/tahun" required>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <label for="tgl_surat">Tanggal Surat <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar-alt"></i></span>
                                        <input id="tgl_surat" class="form-control datepicker" type="text"
                                               name="tgl_surat" placeholder="yyyy-mm-dd" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-7">
                                    <label for="jenis_id">Jenis Surat <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-thumbtack"></i></span>
                                        <select id="jenis_id" class="form-control selectpicker"
                                                title="-- Pilih Jenis Surat --" data-live-search="true"
                                                name="jenis_id" data-max-options="1" multiple required>
                                            @foreach($types as $type)
                                                <option value="{{$type->id}}">{{$type->jenis}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <label for="sifat_surat">Sifat Surat <span class="required">*</span></label>
                                    <div class="radio" id="sifat_surat">
                                        <label style="padding: 0 1em 0 0">
                                            <input id="penting" type="radio" class="flat" name="sifat_surat"
                                                   value="penting" required> Penting</label>
                                        <label style="padding: 0 1em 0 0">
                                            <input id="rahasia" type="radio" class="flat" name="sifat_surat"
                                                   value="rahasia"> Rahasia</label>
                                        <label style="padding: 0 1em 0 0">
                                            <input id="segera" type="radio" class="flat" name="sifat_surat"
                                                   value="segera"> Segera</label>
                                        <label style="padding: 0 1em 0 0">
                                            <input id="sangat_segera" type="radio" class="flat" name="sifat_surat"
                                                   value="sangat segera"> Sangat Segera</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-7">
                                    <label for="perihal">Perihal <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-comments"></i></span>
                                        <input id="perihal" class="form-control" type="text" name="perihal"
                                               placeholder="Perihal" required>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <label for="lampiran">Lampiran <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-file-image"></i></span>
                                        <input id="lampiran" class="form-control" type="text" name="lampiran"
                                               placeholder="Contoh: 1 (satu)" required>
                                        <span class="input-group-addon">lembar</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-7">
                                    <label for="nama_instansi">Nama Instansi Pengirim <span
                                                class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-university"></i></span>
                                        <input id="nama_instansi" placeholder="Nama instansi pengirim" type="text"
                                               class="form-control" name="nama_instansi" required>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <label for="asal_instansi">Asal Instansi Pengirim <span
                                                class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-map-marked-alt"></i></span>
                                        <input id="asal_instansi" placeholder="Asal instansi pengirim" type="text"
                                               class="form-control" name="asal_instansi" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-7">
                                    <label for="nama">Nama Pengirim <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user-tie"></i></span>
                                        <input id="nama" placeholder="Nama lengkap pengirim" type="text"
                                               class="form-control" name="nama_pengirim" required>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <label for="nip">NIP Pengirim <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <input id="nip" placeholder="NIP pengirim" type="text" class="form-control"
                                               name="nip_pengirim" onkeypress="return numberOnly(event, false)"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-7">
                                    <label for="jabatan">Jabatan Pengirim <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                        <input id="jabatan" placeholder="Jabatan pengirim" type="text"
                                               class="form-control" name="jabatan_pengirim" required>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <label for="pangkat">Pangkat Pengirim <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-badge"></i></span>
                                        <input id="pangkat" placeholder="Pangkat pengirim" type="text"
                                               class="form-control" name="pangkat_pengirim" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <label for="tembusan">Tembusan</label>
                                    <textarea id="tembusan" class="use-tinymce" name="tembusan"></textarea>
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
                                    <button type="reset" class="btn btn-default btn-block" id="btn_sm_cancel">
                                        <strong>BATAL</strong></button>
                                </div>
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary btn-block" id="btn_sm_submit">
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
                @if(Auth::user()->isPengolah())
                    <div class="card-content">
                        <div class="card-title">
                            <small>File Surat Masuk <span onclick="showDeleteFiles()" class="pull-right"
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
                @endif
            </div>
        </div>
    </div>
    @if(Auth::user()->isKadin())
        <div id="disposisiModal" class="modal fade">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <form method="post" action="{{route('create.surat-disposisi')}}" id="form-sd">
                        {{csrf_field()}}
                        <input type="hidden" name="_method">
                        <input type="hidden" name="sm_id" id="sm_id">
                        <div class="modal-body">
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <label for="diteruskan_kepada">Diteruskan kepada Saudara: <span
                                                class="required">*</span></label>
                                    <textarea id="diteruskan_kepada" name="diteruskan_kepada"
                                              class="use-tinymce"></textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-5">
                                    <label for="harapan">Dengan hormat harap: <span class="required">*</span></label>
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                        <input id="rb_ts" type="radio" class="flat" name="rb_harapan" required></span>
                                        <input id="txt_ts" class="form-control" type="text" name="harapan"
                                               value="Tanggapan dan Saran" disabled>
                                    </div>
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                        <input id="rb_pll" type="radio" class="flat" name="rb_harapan"></span>
                                        <input id="txt_pll" class="form-control" type="text" name="harapan"
                                               value="Proses Lebih Lanjut" disabled>
                                    </div>
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                        <input id="rb_kk" type="radio" class="flat" name="rb_harapan"></span>
                                        <input id="txt_kk" class="form-control" type="text" name="harapan"
                                               value="Koordinasi / Konfirmasikan" disabled>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <input id="rb_bsb" type="radio" class="flat" name="rb_harapan"></span>
                                        <input id="txt_bsb" class="form-control" type="text" name="harapan"
                                               value="Buat Surat Balasan" disabled>
                                    </div>
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                        <input id="rb_cust" type="radio" class="flat" name="rb_harapan"></span>
                                        <input id="txt_cust" class="form-control" type="text" name="harapan"
                                               placeholder="Tulis harapan disini..." disabled>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <label for="catatan">Catatan:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-clipboard-list"></i></span>
                                        <textarea id="catatan" class="form-control" name="catatan"
                                                  style="resize: vertical;"
                                                  placeholder="Tulis catatan disini..." rows="12"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="btn_sd_submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
@push("scripts")
    <script>
        $(function () {
            @if($findSurat != "")
            $(".dataTables_filter input[type=search]").val('{{$findSurat}}').trigger('keyup');
            @endif
        });

        var $indicators = '', $item = '', $deleteFiles = '', $no_surat = $("#no_surat"),
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

        $("#btn_create, #btn_sm_cancel").on("click", function () {
            $("#content1").toggle(300);
            $("#content2").toggle(300);
            $("#btn_create i").toggleClass('fa-plus fa-th-list');
            $("#btn_sm_submit").html("<strong>SUBMIT</strong>");
            $("#form-sm input[name=_method]").val('');
            $("#form-sm").attr('action', '{{route('create.surat-masuk')}}');

            $("#btn_create[data-toggle=tooltip]").attr('data-original-title', function (i, v) {
                return v === "Buat Surat" ? "Daftar Surat" : "Buat Surat";
            });

            $("#panel_subtitle").html(function (i, v) {
                return v === "Create Form" ? "List" : "Create Form";
            });

            $("#no_surat, #tgl_surat, #perihal, #lampiran, #nama_instansi, #asal_instansi, #nama, #jabatan, #pangkat, #nip").val('');
            $("#jenis_id").val('default').selectpicker('refresh');
            $("#rahasia, #segera, #sangat_segera, #penting").iCheck('uncheck');
            tinyMCE.get('tembusan').setContent('');

            $("#attach-files").val('');
            $("#txt_attach").val('');
            $("#count_files").text('');
            $("#txt_attach[data-toggle=tooltip]").attr('data-original-title', 'Ekstensi file yang boleh diunggah: jpg, jpeg, gif, png. Ukuran file maksimal: < 5 MB');
        });

        $no_surat.inputmask({
            mask: "999/999/999.999/9999",
            placeholder: "___/{{$no_urut}}/___.___/{{now()->format('Y')}}"
        });

        $no_surat.autocomplete({
            source: function (request, response) {
                $.getJSON($no_surat.val().substr(0, 3) + "/perihal", {
                    name: request.term,
                }, function (data) {
                    response(data);
                });
            },
            focus: function (event, ui) {
                event.preventDefault();
            },
            select: function (event, ui) {
                event.preventDefault();
                $no_surat.val(ui.item.kode);
            }
        });

        $("#lampiran").inputmask({mask: "9{1,2} (a{3,25})"});

        $("#form-sm").on("submit", function (e) {
            e.preventDefault();
            if ($("#attach-files").get(0).files.length === 0 && !$("#form-sm input[name=_method]").val()) {
                swal('PERHATIAN!', 'Anda belum mengunggah file surat masuk!', 'warning');
            } else {
                $(this)[0].submit();
            }
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

        $(".delete-surat").on("click", function () {
            var linkURL = $(this).attr("href"),
                surat = $(this).data('surat') == 'masuk' ? 'Surat Masuk' : 'Surat Disposisi';
            swal({
                title: 'Hapus ' + surat,
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

        function editSuratMasuk(id) {
            $("#content1").toggle(300);
            $("#content2").toggle(300);
            $("#btn_create i").toggleClass('fa-plus fa-th-list');
            $("#btn_sm_submit").html("<strong>SIMPAN PERUBAHAN</strong>");
            $("#form-sm input[name=_method]").val('PUT');
            $("#form-sm").attr('action', '{{route('update.surat-masuk', ['id' => ''])}}/' + id);

            $("#btn_create[data-toggle=tooltip]").attr('data-original-title', function (i, v) {
                return v === "Buat Surat" ? "Daftar Surat" : "Buat Surat";
            }).tooltip('show');

            $("#panel_subtitle").html(function (i, v) {
                return v === "Edit Form" ? "List" : "Edit Form";
            });

            $("#attach-files").val('');
            $("#txt_attach").val('');
            $("#count_files").text('');
            $("#txt_attach[data-toggle=tooltip]").attr('data-original-title', 'Ekstensi file yang boleh diunggah: jpg, jpeg, gif, png. Ukuran file maksimal: < 5 MB').tooltip('show');

            $.get('{{route('edit.surat-masuk', ['id' => ''])}}/' + id, function (data) {
                $("#no_surat").val(data.no_surat);
                $("#tgl_surat").val(data.tgl_surat);
                $("#perihal").val(data.perihal);
                $("#lampiran").val(data.lampiran);
                $("#nama_instansi").val(data.nama_instansi);
                $("#asal_instansi").val(data.asal_instansi);
                $("#nama").val(data.nama_pengirim);
                $("#jabatan").val(data.jabatan_pengirim);
                $("#pangkat").val(data.pangkat_pengirim);
                $("#nip").val(data.nip_pengirim);
                $("#jenis_id").val(data.jenis_id).selectpicker('refresh');
                $("#" + data.sifat_surat.replace(/\s/g, "_")).iCheck('check');
                if (data.tembusan != "") {
                    tinyMCE.get('tembusan').setContent(data.tembusan);
                }
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

                            $deleteFiles += '<li><input type="checkbox" name="fileSuratMasuks[]" ' +
                                'class="fileSurat_cb" value="' + val + '">' + text_truncate(val, 25) + '</li>';
                        });
                        $("#lampiranModal .carousel-indicators").html($indicators);
                        $("#lampiranModal .carousel-inner").html($item);

                        $("#delete-files").html(
                            '<form action="{{route('massDelete.surat-masuk',['id' => ''])}}/' + id + '" ' +
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
                                title: 'Hapus File Surat Masuk',
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

        function disposisiSurat(id, no_surat, method) {
            var $form = $("#form-sd");
            $("#sm_id").val(id);

            $("#rb_ts").on("ifToggled", function () {
                if ($(this).is(":checked")) {
                    $("#txt_ts").removeAttr('disabled').attr('readonly', 'readonly')
                        .css('color', '#31c2a5').css('border-color', '#31c2a5');
                    $(this).parent().parent().css('border-color', '#31c2a5');
                } else {
                    $("#txt_ts").attr('disabled', 'disabled')
                        .css('background', '#eee').css('color', '#555').css('border-color', '#ccc');
                    $(this).parent().parent().css('border-color', '#ccc');
                }
            });

            $("#rb_pll").on("ifToggled", function () {
                if ($(this).is(":checked")) {
                    $("#txt_pll").removeAttr('disabled').attr('readonly', 'readonly')
                        .css('color', '#31c2a5').css('border-color', '#31c2a5');
                    $(this).parent().parent().css('border-color', '#31c2a5');
                } else {
                    $("#txt_pll").attr('disabled', 'disabled')
                        .css('background', '#eee').css('color', '#555').css('border-color', '#ccc');
                    $(this).parent().parent().css('border-color', '#ccc');
                }
            });

            $("#rb_kk").on("ifToggled", function () {
                if ($(this).is(":checked")) {
                    $("#txt_kk").removeAttr('disabled').attr('readonly', 'readonly')
                        .css('color', '#31c2a5').css('border-color', '#31c2a5');
                    $(this).parent().parent().css('border-color', '#31c2a5');
                } else {
                    $("#txt_kk").attr('disabled', 'disabled')
                        .css('background', '#eee').css('color', '#555').css('border-color', '#ccc');
                    $(this).parent().parent().css('border-color', '#ccc');
                }
            });

            $("#rb_bsb").on("ifToggled", function () {
                if ($(this).is(":checked")) {
                    $("#txt_bsb").removeAttr('disabled').attr('readonly', 'readonly')
                        .css('background', '#31c2a5').css('color', '#fff').css('border-color', '#31c2a5');
                    $(this).parent().parent().css('border-color', '#31c2a5');
                } else {
                    $("#txt_bsb").attr('disabled', 'disabled')
                        .css('background', '#eee').css('color', '#555').css('border-color', '#ccc');
                    $(this).parent().parent().css('border-color', '#ccc');
                }
            });

            $("#rb_cust").on("ifToggled", function () {
                if ($(this).is(":checked")) {
                    $("#txt_cust").val('').removeAttr('disabled').attr('required', 'required').css('border-color', '#31c2a5');
                    $(this).parent().parent().css('border-color', '#31c2a5');
                } else {
                    $("#txt_cust").val('').removeAttr('required').attr('disabled', 'disabled').css('border-color', '#ccc');
                    $(this).parent().parent().css('border-color', '#ccc');
                }
            });

            if (method == 'create') {
                $("#disposisiModal .modal-title").html('Buat Disposisi Surat Masuk #<strong>' + no_surat + '</strong>');
                $("#btn_sd_submit").html("<strong>Submit</strong>");
                $("#form-sd input[name=_method]").val('');
                $form.attr('action', '{{route('create.surat-disposisi')}}');

                tinymce.get('diteruskan_kepada').setContent('');
                $("#catatan").val('');
                $("#rb_ts, #rb_pll, #rb_kk, #rb_bsb, #rb_cust").iCheck('uncheck');
                $("#txt_ts, #txt_pll, #txt_kk, #txt_bsb").attr('disabled', 'disabled');
                $("#txt_cust").removeAttr('required').attr('disabled', 'disabled');

            } else if (method == 'update') {
                $("#disposisiModal .modal-title").html('Edit Disposisi Surat Masuk #<strong>' + no_surat + '</strong>');
                $("#btn_sd_submit").html("<strong>Simpan Perubahan</strong>");
                $("#form-sd input[name=_method]").val('PUT');
                $form.attr('action', '{{route('update.surat-disposisi', ['id' => ''])}}/' + id);

                $.get('{{route('edit.surat-disposisi', ['id' => ''])}}/' + id, function (data) {
                    tinymce.get('diteruskan_kepada').setContent(data.diteruskan_kepada);
                    $("#catatan").val(data.catatan);

                    if (data.harapan == 'Tanggapan dan Saran') {
                        $("#rb_ts").iCheck('check');
                        $("#txt_ts").removeAttr('disabled').attr('readonly', 'readonly');
                        $("#txt_pll, #txt_kk, #txt_bsb").attr('disabled', 'disabled');
                        $("#txt_cust").removeAttr('required').attr('disabled', 'disabled');

                    } else if (data.harapan == 'Proses Lebih Lanjut') {
                        $("#rb_pll").iCheck('check');
                        $("#txt_pll").removeAttr('disabled').attr('readonly', 'readonly');
                        $("#txt_ts, #txt_kk, #txt_bsb").attr('disabled', 'disabled');
                        $("#txt_cust").removeAttr('required').attr('disabled', 'disabled');

                    } else if (data.harapan == 'Koordinasi / Konfirmasikan') {
                        $("#rb_kk").iCheck('check');
                        $("#txt_kk").removeAttr('disabled').attr('readonly', 'readonly');
                        $("#txt_ts, #txt_pll, #txt_bsb").attr('disabled', 'disabled');
                        $("#txt_cust").removeAttr('required').attr('disabled', 'disabled');

                    } else if (data.harapan == 'Buat Surat Balasan') {
                        $("#rb_bsb").iCheck('check');
                        $("#txt_bsb").removeAttr('disabled').attr('readonly', 'readonly');
                        $("#txt_ts, #txt_pll, #txt_kk").attr('disabled', 'disabled');
                        $("#txt_cust").removeAttr('required').attr('disabled', 'disabled');

                    } else {
                        $("#rb_cust").iCheck('check');
                        $("#txt_cust").val(data.harapan).removeAttr('disabled').attr('required', 'required');
                        $("#txt_ts, #txt_pll, #txt_kk, #txt_bsb").attr('disabled', 'disabled');
                    }
                });
            }

            $form.on("submit", function (e) {
                e.preventDefault();
                if (tinyMCE.get('diteruskan_kepada').getContent() == "") {
                    swal('PERHATIAN!', 'Kolom diteruskan_kepada harus diisi!', 'warning');
                } else {
                    $(this)[0].submit();
                }
            });

            $("#disposisiModal").modal('show');
        }
    </script>
@endpush
