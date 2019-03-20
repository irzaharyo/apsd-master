@extends('layouts.mst_template')
@section('rincian')
    <h4 style="text-transform: uppercase;text-align: center;font-weight: 600">{{$sk->perihal}}</h4>
    <p align="center">
        <u style="text-transform: uppercase;font-weight: 600;">{{$sk->getJenisSurat->jenis}}</u><br>Nomor: {{$sk->no_surat}}
    </p>
@endsection
@section('ttd')
    <table>
        <tr>
            <td width="50%">
                <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Menyetujui,</td>
                    </tr>
                    <tr>
                        <td style="text-transform: uppercase ; font-weight: 600">{{$sk->instansi_penerima}}
                            <br>{{'kota '.$sk->kota_penerima}}</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <u style="font-weight: 600">{{$sk->nama_penerima}}</u><br>
                            {{$sk->jabatan_penerima}}@if($sk->pangkat_penerima != ""){{' / '.$sk->pangkat_penerima}}@endif
                            @if($sk->nip_penerima != "")<br>NIP. {{$sk->nip_penerima}}@endif
                        </td>
                    </tr>
                </table>
            </td>
            <td width="50%">
                <table>
                    <tr>
                        <td>Madiun, {{strftime('%d %B %Y', strtotime($sk->tgl_surat))}}</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-transform: uppercase ; font-weight: 600">{{$kadin->jabatan}}<br>kota madiun</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <u style="font-weight: 600">{{$kadin->name}}</u><br>
                            {{$kadin->pangkat}}<br>NIP. {{$kadin->nip}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection