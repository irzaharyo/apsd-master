<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Surat Keluar</title>
    <style>
        h1, h2, h3, h4, h5, h6 {
            text-align: center;
        }

        #data-table:not(table) {
            width: auto;
            border-collapse: collapse;
            margin: 0 auto;
        }

        #data-table td, th {
            border: 1px solid #ddd;
            text-align: left;
            padding: 8px;
        }

        #data-table tr:nth-child(even) {
            background-color: #eee;
        }
    </style>
</head>
<body>
<h1 style="margin-bottom: 5px">Daftar Surat Keluar</h1>
<h2 style="margin-top: 0;margin-bottom: 5px">Dinas Pertanian dan Ketahanan Pangan</h2>
<h3 style="margin-top: 0;margin-bottom: 5px">Kota Madiun</h3>
<hr style="margin-bottom: .5em">
<table border="0" cellpadding="0" cellspacing="0" align="center" id="data-table">
    <tr>
        <th>No</th>
        <th>Tanggal Pengajuan</th>
        <th>Nomor/Tanggal Surat</th>
        <th>Jenis Surat</th>
        <th>Penerima</th>
        <th>Perihal</th>
        <th>Lampiran</th>
        <th>Sifat Surat</th>
        <th>Status</th>
    </tr>
    @php $no = 1; @endphp
    @foreach($keluars as $keluar)
        @php
            if($keluar->status == 0){
                $status = 'Diproses';
            } elseif($keluar->status == 1){
                $status = 'Menunggu Validasi';
            } elseif($keluar->status == 2){
                $status = 'Valid';
            } elseif($keluar->status == 3){
                $status = 'Tidak Valid';
            } elseif($keluar->status == 4){
                $status = 'Surat Siap Diambil';
            } elseif($keluar->status == 5){
                $status = 'Surat Sudah Diambil';
            }
        @endphp
        <tr>
            <td style="vertical-align: middle" align="center">{{$no++}}</td>
            <td style="vertical-align: middle" align="center">
                {{\Carbon\Carbon::parse($keluar->created_at)->format('l, j F Y')}}</td>
            <td style="vertical-align: middle">
                {{$keluar->no_surat}}<br>{{\Carbon\Carbon::parse($keluar->tgl_surat)->format('j F Y')}}</td>
            <td style="vertical-align: middle" align="center">
                {{$keluar->getJenisSurat->jenis}}</td>
            <td style="vertical-align: middle">{{$keluar->nama_penerima.', '.$keluar->kota_penerima}}</td>
            <td style="vertical-align: middle">{{$keluar->perihal}}</td>
            <td style="vertical-align: middle" align="center">{{$keluar->lampiran}}</td>
            <td style="vertical-align: middle; text-transform: uppercase" align="center">{{$keluar->sifat_surat}}</td>
            <td style="vertical-align: middle" align="center">{{$status}}</td>
        </tr>
    @endforeach
</table>
</body>
</html>