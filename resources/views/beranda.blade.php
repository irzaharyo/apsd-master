@extends('layouts.mst')
@section('title', 'Beranda '.env('APP_NAME').' - Aplikasi Pengarsipan Surat dan Disposisi | Dinas Pertanian dan Ketahanan Pangan Kota Madiun')
@push("styles")
    <style>
        .dataTables_filter {
            /*width: 70%;*/
            width: auto;
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
            <div class="col-md-6 col-sm-6 col-xs-12">
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
                                <th>Nomor Surat</th>
                                <th>Detail Surat</th>
                                <th>Disposisi</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($masuks as $masuk)
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle"><strong>{{$masuk->no_surat}}</strong></td>
                                    <td style="vertical-align: middle">
                                        <p>
                                            lorem ipsum
                                        </p>
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <span class="label label-{{$masuk->isDisposisi == true ? 'success' : 'danger'}}"
                                              style="text-transform: uppercase">{{$masuk->isDisposisi == true ? 'Ya' : 'Tidak'}}</span>
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <a onclick='lihatLampiran("{{$masuk->id}}")' class="btn btn-dark btn-sm"
                                           style="font-size: 16px" data-toggle="tooltip" title="Lampiran"
                                           data-placement="left"><i class="fa fa-images"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12">
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
                                <th>Nomor Surat</th>
                                <th>Detail Surat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($keluars as $keluar)
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle"><strong>{{$keluar->no_surat}}</strong></td>
                                    <td style="vertical-align: middle">
                                        <p>
                                            lorem ipsum
                                        </p>
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
                                        <a onclick='lihatLampiran("{{$keluar->id}}")' class="btn btn-dark btn-sm"
                                           style="font-size: 16px" data-toggle="tooltip" title="Lampiran"
                                           data-placement="left"><i class="fa fa-images"></i></a>
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
@endsection
@push("scripts")
    <script>

    </script>
@endpush
