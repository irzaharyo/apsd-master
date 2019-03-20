@extends('layouts.mst')
@section('title', 'Surat Keluar | '.env('APP_NAME').' - Aplikasi Pengarsipan Surat dan Disposisi | Dinas Pertanian dan Ketahanan Pangan Kota Madiun')
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
                        <h2>Surat Keluar
                            <small id="panel_subtitle">List</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            @if(Auth::user()->isPegawai())
                                <li><a id="btn_create" data-toggle="tooltip" title="Ajukan Surat"
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
                                                <td>{{\Carbon\Carbon::parse($keluar->created_at)->format('l, j F Y - h:i:s')}}</td>
                                            </tr>
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
                                        @if(Auth::user()->isPegawai())
                                            <div class="btn-group">
                                                @if($keluar->status == 0 && $keluar->user_id == Auth::id())
                                                    <button onclick='editSuratKeluar("{{$keluar->id}}")' type="button"
                                                            class="btn btn-warning btn-sm" style="font-weight: 600">
                                                        <i class="fa fa-edit"></i>&ensp;EDIT
                                                    </button>
                                                @else
                                                    <button onclick='konfirmasiSuratKeluar("{{$keluar->id}}",
                                                            "{{$keluar->no_surat}}")' type="button"
                                                            class="btn btn-success btn-sm" style="font-weight: 600"
                                                            {{$keluar->status == 0 || $keluar->status == 1 ||
                                                            $keluar->status == 2 || $keluar->status == 3 ||
                                                            $keluar->status == 5 ? 'disabled' : ''}}>
                                                        {{$keluar->status == 5 ? 'TERKONFIRMASI' : 'KONFIRMASI'}}
                                                    </button>
                                                @endif
                                                <button type="button" class="btn btn-{{$keluar->status == 0 &&
                                                $keluar->user_id == Auth::id() ? 'warning' : 'success'}} btn-sm dropdown-toggle"
                                                        data-toggle="dropdown" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                        @if($keluar->status == 0 || $keluar->status >= 4)
                                                            <a onclick='lihatSurat("{{$keluar->id}}", "keluar",
                                                                    "{{$lbr}}", "{{$index}}")'>
                                                                <i class="fa fa-images"></i>&ensp;{{'Lihat Surat ('.$lbr.
                                                                ' lembar)'}}
                                                            </a>
                                                        @else
                                                            <a href="{{route('pdf.surat-keluar', ['id' => encrypt
                                                            ($keluar->id)])}}" target="_blank">
                                                                <i class="fa fa-file-pdf"></i>&ensp;Lihat Surat
                                                            </a>
                                                        @endif
                                                    </li>
                                                    @if($keluar->status == 0 && $keluar->user_id == Auth::id())
                                                        <li>
                                                            <a href="{{route('delete.surat-keluar',['id' => encrypt
                                                            ($keluar->id)])}}" class="delete-surat">
                                                                <i class="fa fa-trash"></i>&ensp;Hapus Surat
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @elseif(Auth::user()->isPengolah())
                                            <div class="btn-group">
                                                <button onclick='editSuratKeluar("{{$keluar->id}}")' type="button"
                                                        class="btn btn-warning btn-sm" style="font-weight: 600"
                                                        {{$keluar->status == 0 || $keluar->status == 1 ||
                                                        $keluar->status == 3 ? '' : 'disabled'}}>
                                                    <i class="fa fa-edit"></i>&ensp;EDIT
                                                </button>
                                                <button type="button" class="btn btn-warning btn-sm dropdown-toggle"
                                                        data-toggle="dropdown" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                        @if($keluar->status == 0 || $keluar->status >= 4)
                                                            <a onclick='lihatSurat("{{$keluar->id}}", "keluar",
                                                                    "{{$lbr}}", "{{$index}}")'>
                                                                <i class="fa fa-images"></i>&ensp;{{'Lihat Surat ('.$lbr.
                                                                ' lembar)'}}
                                                            </a>
                                                        @else
                                                            <a href="{{route('pdf.surat-keluar', ['id' => encrypt
                                                            ($keluar->id)])}}" target="_blank">
                                                                <i class="fa fa-file-pdf"></i>&ensp;Lihat Surat
                                                            </a>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </div>
                                        @elseif(Auth::user()->isKadin())
                                            <div class="btn-group">
                                                @if($keluar->status == 0 && $keluar->user_id == Auth::id())
                                                    <button onclick='editSuratKeluar("{{$keluar->id}}")' type="button"
                                                            class="btn btn-warning btn-sm" style="font-weight: 600">
                                                        <i class="fa fa-edit"></i>&ensp;EDIT
                                                    </button>
                                                @else
                                                    <button onclick='validasiSuratKeluar("{{$keluar->id}}")'
                                                            type="button"
                                                            class="btn btn-success btn-sm" style="font-weight: 600" {{$keluar->status
                                                             == 1 || $keluar->status == 3 ? '' : 'disabled'}}>
                                                        <i class="fa fa-edit"></i>&ensp;{{$keluar->status == 2 ||
                                                        $keluar->status == 4 || $keluar->status == 5 ?
                                                        'TERVALIDASI' : 'VALIDASI'}}
                                                    </button>
                                                @endif
                                                <button type="button" class="btn btn-{{$keluar->status == 0 &&
                                                $keluar->user_id == Auth::id() ? 'warning' : 'success'}} btn-sm dropdown-toggle"
                                                        data-toggle="dropdown" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                        @if($keluar->status == 0 || $keluar->status >= 4)
                                                            <a onclick='lihatSurat("{{$keluar->id}}", "keluar",
                                                                    "{{$lbr}}", "{{$index}}")'>
                                                                <i class="fa fa-images"></i>&ensp;{{'Lihat Surat ('.$lbr.
                                                                ' lembar)'}}
                                                            </a>
                                                        @else
                                                            <a href="{{route('pdf.surat-keluar', ['id' => encrypt
                                                            ($keluar->id)])}}" target="_blank">
                                                                <i class="fa fa-file-pdf"></i>&ensp;Lihat Surat
                                                            </a>
                                                        @endif
                                                    </li>
                                                    @if($keluar->status == 0 && $keluar->user_id == Auth::id())
                                                        <li>
                                                            <a href="{{route('delete.surat-keluar',['id' => encrypt
                                                            ($keluar->id)])}}" class="delete-surat">
                                                                <i class="fa fa-trash"></i>&ensp;Hapus Surat
                                                            </a>
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
                        <form method="post" action="{{route('create.surat-keluar')}}" id="form-sk">
                            {{csrf_field()}}
                            <input type="hidden" name="_method">
                            @if(Auth::user()->isPegawai())
                                <div class="row form-group">
                                    <div class="col-lg-12">
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
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-12">
                                        <label for="perihal">Perihal <span class="required">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-comments"></i></span>
                                            <input id="perihal" class="form-control" type="text" name="perihal"
                                                   placeholder="Perihal" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-7">
                                        <label for="nama_instansi">Nama Instansi Penerima <span
                                                    class="required">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-university"></i></span>
                                            <input id="nama_instansi" placeholder="Nama instansi penerima" type="text"
                                                   class="form-control" name="instansi_penerima" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <label for="kota">Asal Instansi Penerima <span class="required">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-map-marked-alt"></i></span>
                                            <input id="kota" placeholder="Asal instansi penerima" type="text"
                                                   class="form-control" name="kota_penerima" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-7">
                                        <label for="nama">Nama Penerima <span class="required">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user-tie"></i></span>
                                            <input id="nama" placeholder="Nama lengkap penerima" type="text"
                                                   class="form-control" name="nama_penerima" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <label for="nip">NIP Penerima <span class="required">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                            <input id="nip" placeholder="NIP penerima" type="text" class="form-control"
                                                   name="nip_penerima" onkeypress="return numberOnly(event, false)"
                                                   required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-7">
                                        <label for="jabatan">Jabatan Penerima <span class="required">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                            <input id="jabatan" placeholder="Jabatan penerima" type="text"
                                                   class="form-control" name="jabatan_penerima" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <label for="pangkat">Pangkat Penerima <span class="required">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-id-badge"></i></span>
                                            <input id="pangkat" placeholder="Pangkat penerima" type="text"
                                                   class="form-control"
                                                   name="pangkat_penerima" onkeypress="return numberOnly(event, false)"
                                                   required>
                                        </div>
                                    </div>
                                </div>

                            @elseif(Auth::user()->isPengolah())
                                <div class="col-lg-12 alert alert-danger"
                                     style="display: none;background-color: #f2dede;border-color: #ebccd1;color: #a94442;">
                                    <strong>INVALID!</strong> &mdash; <span id="stats_invalid"></span>
                                </div>
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
                                                <input id="sangat_segera" type="radio" class="flat"
                                                       name="sifat_surat"
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
                                        <label for="nama_instansi">Nama Instansi Penerima <span
                                                    class="required">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-university"></i></span>
                                            <input id="nama_instansi" placeholder="Nama instansi penerima" type="text"
                                                   class="form-control" name="instansi_penerima" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <label for="kota">Asal Instansi Penerima <span class="required">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-map-marked-alt"></i></span>
                                            <input id="kota" placeholder="Asal instansi penerima" type="text"
                                                   class="form-control" name="kota_penerima" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-7">
                                        <label for="nama">Nama Penerima <span class="required">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user-tie"></i></span>
                                            <input id="nama" placeholder="Nama lengkap penerima" type="text"
                                                   class="form-control" name="nama_penerima" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <label for="nip">NIP Penerima <span class="required">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                            <input id="nip" placeholder="NIP penerima" type="text" class="form-control"
                                                   name="nip_penerima" onkeypress="return numberOnly(event, false)"
                                                   required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-7">
                                        <label for="jabatan">Jabatan Penerima <span class="required">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                            <input id="jabatan" placeholder="Jabatan penerima" type="text"
                                                   class="form-control" name="jabatan_penerima" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <label for="pangkat">Pangkat Penerima <span class="required">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-id-badge"></i></span>
                                            <input id="pangkat" placeholder="Pangkat penerima" type="text"
                                                   class="form-control"
                                                   name="pangkat_penerima" onkeypress="return numberOnly(event, false)"
                                                   required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-12">
                                        <label for="isi">Isi Surat<span class="required">*</span></label>
                                        <textarea id="isi" class="use-tinymce" name="isi"></textarea>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-12">
                                        <label for="tembusan">Tembusan</label>
                                        <textarea id="tembusan" class="use-tinymce" name="tembusan"></textarea>
                                    </div>
                                </div>
                            @endif

                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <button type="reset" class="btn btn-default btn-block" id="btn_sk_cancel">
                                        <strong>BATAL</strong></button>
                                </div>
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary btn-block" id="btn_sk_submit">
                                        <strong>SUBMIT</strong></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(Auth::user()->isKadin())
        <div id="validasiModal" class="modal fade">
            <div class="modal-dialog" style="width: 45%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <form method="post" id="form-validasi">
                        {{csrf_field()}}
                        {{method_field('PUT')}}
                        <div class="modal-body">
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <input id="rb_valid" type="radio" class="flat" value="2" name="rb_status"
                                                   required></span>
                                        <input id="txt_valid" class="form-control" type="text" value="Surat Valid"
                                               disabled>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <input id="rb_invalid" type="radio" class="flat" value="3" name="rb_status"></span>
                                        <textarea id="txt_invalid" class="form-control" type="text" name="catatan"
                                                  placeholder="Tulis catatan disini..." disabled
                                                  style="resize: vertical"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="btn_validasi_submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
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
            $(".dataTables_filter input[type=search]").val('{{$findSurat}}').trigger('keyup');
            @endif
        });

        var $indicators = '', $item = '', $no_surat = $("#no_surat");

        $("#btn_create, #btn_sk_cancel").on("click", function () {
            $("#content1").toggle(300);
            $("#content2").toggle(300);
            $("#btn_create i").toggleClass('fa-plus fa-th-list');
            $("#btn_sk_submit").html("<strong>SUBMIT</strong>");
            $("#form-sk input[name=_method]").val('');
            $("#form-sk").attr('action', '{{route('create.surat-keluar')}}');

            $("#btn_create[data-toggle=tooltip]").attr('data-original-title', function (i, v) {
                return v === "Ajukan Surat" ? "Daftar Surat" : "Ajukan Surat";
            });

            $("#panel_subtitle").html(function (i, v) {
                return v === "Create Form" ? "List" : "Create Form";
            });

            $("#perihal, #nama_instansi, #kota, #nama, #jabatan, #pangkat, #nip").val('');
            $("#jenis_id").val('default').selectpicker('refresh');
        });

        $no_surat.inputmask({
            mask: "999/999/999.999/9999",
            placeholder: "___/{{$no_urut}}/401.113/{{now()->format('Y')}}"
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

        @if(Auth::user()->isPengolah())
        $("#form-sk").on("submit", function (e) {
            e.preventDefault();
            if (tinyMCE.get('isi').getContent() == "") {
                swal('PERHATIAN!', 'Kolom isi surat harus diisi!', 'warning');
            } else {
                $(this)[0].submit();
            }
        });
        @endif

        $(".delete-surat").on("click", function () {
            var linkURL = $(this).attr("href");
            swal({
                title: 'Hapus Surat Keluar',
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

        function editSuratKeluar(id) {
            $("#content1").toggle(300);
            $("#content2").toggle(300);
            $("#btn_create i").toggleClass('fa-plus fa-th-list');
            $("#btn_sk_submit").html("<strong>SIMPAN PERUBAHAN</strong>");
            $("#form-sk input[name=_method]").val('PUT');
            $("#form-sk").attr('action', '{{route('update.surat-keluar', ['id' => ''])}}/' + id);

            $("#btn_create[data-toggle=tooltip]").attr('data-original-title', function (i, v) {
                return v === "Ajukan Surat" ? "Daftar Surat" : "Ajukan Surat";
            }).tooltip('show');

            $("#panel_subtitle").html(function (i, v) {
                return v === "Edit Form" ? "List" : "Edit Form";
            });

            $.get('{{route('edit.surat-keluar', ['id' => ''])}}/' + id, function (data) {
                $("#perihal").val(data.perihal);
                $("#nama_instansi").val(data.instansi_penerima);
                $("#kota").val(data.kota_penerima);
                $("#nama").val(data.nama_penerima);
                $("#jabatan").val(data.jabatan_penerima);
                $("#pangkat").val(data.pangkat_penerima);
                $("#nip").val(data.nip_penerima);
                $("#jenis_id").val(data.jenis_id).selectpicker('refresh');

                @if(Auth::user()->isPengolah())
                if (data.status == 3) {
                    $("#stats_invalid").text(data.catatan).parent().show(300);
                }
                $("#no_surat").val(data.no_surat);
                $("#tgl_surat").val(data.tgl_surat);
                $("#lampiran").val(data.lampiran);
                $("#" + data.sifat_surat.replace(/\s/g, "_")).iCheck('check');
                tinyMCE.get('isi').setContent(data.isi);
                if (data.tembusan != "") {
                    tinyMCE.get('tembusan').setContent(data.tembusan);
                }
                @endif
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

        function validasiSuratKeluar(id) {
            $("#rb_valid").on("ifToggled", function () {
                if ($(this).is(":checked")) {
                    $("#txt_valid").removeAttr('disabled').attr('readonly', 'readonly')
                        .css('background', '#31c2a5').css('color', '#fff').css('border-color', '#31c2a5');
                    $(this).parent().parent().css('border-color', '#31c2a5');
                } else {
                    $("#txt_valid").attr('disabled', 'disabled')
                        .css('background', '#eee').css('color', '#555').css('border-color', '#ccc');
                    $(this).parent().parent().css('border-color', '#ccc');
                }
            });

            $("#rb_invalid").on("ifToggled", function () {
                if ($(this).is(":checked")) {
                    $("#txt_invalid").removeAttr('disabled').attr('required', 'required').css('border-color', '#31c2a5');
                    $(this).parent().parent().css('border-color', '#31c2a5');
                } else {
                    $("#txt_invalid").removeAttr('required').attr('disabled', 'disabled').css('border-color', '#ccc');
                    $(this).parent().parent().css('border-color', '#ccc');
                }
            });

            $.get('{{route('edit.surat-keluar', ['id' => ''])}}/' + id, function (data) {
                $("#validasiModal .modal-title").html('Validasi Surat Keluar #<strong>' + data.no_surat + '</strong>');
                $("#btn_validasi_submit").html("<strong>" + data.status == 2 ? 'SIMPAN PERUBAHAN' : 'SUBMIT' + "</strong>");
                if (data.catatan != "") {
                    $("#rb_invalid").iCheck('check');
                    $("#txt_invalid").val(data.catatan);
                } else {
                    $("#rb_valid").iCheck('check');
                    $("#txt_invalid").val('');
                }
            });

            $("#form-validasi").attr('action', '{{route('update.surat-keluar', ['id' => ''])}}/' + id);
            $("#validasiModal").modal('show');
        }

        function konfirmasiSuratKeluar(id, no_surat) {
            swal({
                title: 'Konfirmasi Pengambilan Surat',
                text: 'Apakah Anda yakin sudah mengambil surat keluar #' + no_surat + '? Anda tidak dapat mengembalikannya!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#169F85',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return new Promise(function (resolve) {
                        window.location.href = '{{route('confirm.surat-keluar', ['id' => ''])}}/' + id;
                    });
                },
                allowOutsideClick: false
            });
        }
    </script>
@endpush
