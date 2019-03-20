@extends('layouts.mst_template')
@section('rincian')
    <p align="center">
        <u style="text-transform: uppercase;font-weight: 600;">{{$sk->getJenisSurat->jenis}}</u><br>Nomor: {{$sk->no_surat}}
    </p>
@endsection
@section('ttd')
    <table>
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%">Madiun, {{strftime('%d %B %Y', strtotime($sk->tgl_surat))}}</td>
        </tr>
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%" style="text-transform: uppercase ; font-weight: 600">{{$kadin->jabatan}}<br>kota madiun
            </td>
        </tr>
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%">&nbsp;</td>
        </tr>
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%">&nbsp;</td>
        </tr>
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%">&nbsp;</td>
        </tr>
        <tr>
            <td width="60%">&nbsp;</td>
            <td width="40%">
                <u style="font-weight: 600">{{$kadin->name}}</u><br>
                {{$kadin->pangkat}}<br>NIP. {{$kadin->nip}}
            </td>
        </tr>
    </table>
@endsection