<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Surat Masuk</title>
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
<h1 style="margin-bottom: 5px">Daftar Surat Masuk</h1>
<h2 style="margin-top: 0;margin-bottom: 5px">Dinas Pertanian dan Ketahanan Pangan</h2>
<h3 style="margin-top: 0;margin-bottom: 5px">Kota Madiun</h3>
<hr style="margin-bottom: .5em">
<table border="0" cellpadding="0" cellspacing="0" align="center" id="data-table">
    <tr>
        <th>No</th>
        <th>Tanggal Penerimaan</th>
        <th>Nomor/Tanggal Surat</th>
        <th>Jenis Surat</th>
        <th>Pengirim</th>
        <th>Perihal</th>
        <th>Lampiran</th>
        <th>Sifat Surat</th>
        <th>Status</th>
    </tr>
    @php $no = 1; @endphp
    @foreach($masuks as $masuk)
        <tr>
            <td style="vertical-align: middle" align="center">{{$no++}}</td>
            <td style="vertical-align: middle" align="center">
                {{\Carbon\Carbon::parse($masuk->created_at)->format('l, j F Y')}}</td>
            <td style="vertical-align: middle">
                {{$masuk->no_surat}}<br>{{\Carbon\Carbon::parse($masuk->tgl_surat)->format('j F Y')}}</td>
            <td style="vertical-align: middle" align="center">
                {{$masuk->getJenisSurat->jenis}}</td>
            <td style="vertical-align: middle">
                {{$masuk->nama_pengirim.' - '.$masuk->nama_instansi.', '.$masuk->asal_instansi}}</td>
            <td style="vertical-align: middle">{{$masuk->perihal}}</td>
            <td style="vertical-align: middle" align="center">{{$masuk->lampiran}}</td>
            <td style="vertical-align: middle; text-transform: uppercase" align="center">{{$masuk->sifat_surat}}</td>
            <td style="vertical-align: middle" align="center">
                {{$masuk->isDisposisi == true ? 'TERDISPOSISI' : 'BELUM DIDISPOSISI'}}
            </td>
        </tr>
    @endforeach
</table>
</body>
</html>