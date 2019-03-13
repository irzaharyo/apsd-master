@extends('layouts.mst_template')
@section('rincian')
    <p align="center">
        <u style="text-transform: uppercase;font-weight: 600;">{{$sk->getJenisSurat->jenis}}</u><br>Nomor: {{$sk->no_surat}}
    </p>
@endsection
@section('tgl_surat')
    <tr>
        <td width="60%">&nbsp;</td>
        <td width="40%">Madiun, {{strftime('%d %B %Y', strtotime($sk->tgl_surat))}}</td>
    </tr>
@endsection