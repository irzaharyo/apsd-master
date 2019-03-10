@extends('layouts.mst')
@section('title', 'Daftar Staff | '.env('APP_NAME').' - Aplikasi Pengarsipan Surat dan Disposisi | Dinas Pertanian dan Ketahanan Pangan Kota Madiun')
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
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Staff
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
                                <th>Detail</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($users as $user)
                                @php

                                        @endphp
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle">
                                        <table>
                                            <tr>
                                                <td>
                                                    <a href="{{route('show.profile', ['role' => $user->role,
                                                    'id' => encrypt($user->id)])}}" target="_blank"
                                                       style="float: left;margin-right: .5em;margin-bottom: .5em">
                                                        <img class="img-responsive" width="100" alt="avatar.png"
                                                             src="{{$user->ava == "" || $user->ava == "avatar.png" ?
                                                             asset('images/avatar.png') :
                                                             asset('storage/users/'.$user->ava)}}">
                                                    </a>
                                                    <table style="margin: 0">
                                                        <tr>
                                                            <td><i class="fa fa-id-card"></i>&nbsp;</td>
                                                            <td>NIP</td>
                                                            <td>&nbsp;:&nbsp;</td>
                                                            <td>{{$user->nip}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-user-tie"></i>&nbsp;</td>
                                                            <td>Nama Lengkap</td>
                                                            <td>&nbsp;:&nbsp;</td>
                                                            <td>{{$user->name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-briefcase"></i>&nbsp;</td>
                                                            <td>Jabatan</td>
                                                            <td>&nbsp;:&nbsp;</td>
                                                            <td>{{$user->jabatan}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-transgender"></i>&nbsp;</td>
                                                            <td>Jenis Kelamin</td>
                                                            <td>&nbsp;:&nbsp;</td>
                                                            <td>{{ucfirst($user->jk)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-home"></i>&nbsp;</td>
                                                            <td>Alamat</td>
                                                            <td>&nbsp;:&nbsp;</td>
                                                            <td>{{$user->alamat}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-phone"></i>&nbsp;</td>
                                                            <td>Nomor Hp/Telp.</td>
                                                            <td>&nbsp;:&nbsp;</td>
                                                            <td>{{$user->nmr_hp}}</td>
                                                        </tr>
                                                    </table>
                                                    <hr style="margin: .5em 0">
                                                    <table style="margin: 0">
                                                        <tr>
                                                            <td><i class="fa fa-envelope"></i>&nbsp;</td>
                                                            <td>E-mail</td>
                                                            <td>&nbsp;:&nbsp;</td>
                                                            <td>{{$user->email}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-user-shield"></i>&nbsp;</td>
                                                            <td>Role</td>
                                                            <td>&nbsp;:&nbsp;</td>
                                                            <td>{{ucfirst($user->role)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-clock"></i>&nbsp;</td>
                                                            <td>Last Update</td>
                                                            <td>&nbsp;:&nbsp;</td>
                                                            <td>{{\Carbon\Carbon::parse($user->updated_at)
                                                ->format('l, j F Y - h:i:s')}}</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <a href="{{route('show.profile', ['role' => $user->role, 'id' =>
                                        encrypt($user->id)])}}" target="_blank" class="btn btn-info btn-sm">
                                            <strong><i class="fa fa-info-circle"></i>&ensp;LIHAT PROFIL</strong>
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
@endsection
