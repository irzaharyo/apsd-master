<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Surat Disposisi</title>
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
<h1 style="margin-bottom: 5px">Daftar Surat Disposisi</h1>
<h2 style="margin-top: 0;margin-bottom: 5px">Dinas Pertanian dan Ketahanan Pangan</h2>
<h3 style="margin-top: 0;margin-bottom: 5px">Kota Madiun</h3>
<hr style="margin-bottom: .5em">
<table border="0" cellpadding="0" cellspacing="0" align="center" id="data-table">
    <tr>
        <th>No</th>
        <th>Nomor/Tanggal Surat</th>
        <th>Diteruskan Kepada</th>
        <th>Dengan Hormat Harap</th>
        <th>Catatan</th>
    </tr>
    @php $no = 1; @endphp
    @foreach($disposisis as $disposisi)
        <tr>
            <td style="vertical-align: middle" align="center">{{$no++}}</td>
            <td style="vertical-align: middle">
                <strong>{{$disposisi->getSuratMasuk->no_surat}}</strong><br>
                {{\Carbon\Carbon::parse($disposisi->getSuratMasuk->tgl_surat)->format('j F Y')}}</td>
            <td style="vertical-align: middle">{!!$disposisi->diteruskan_kepada!!}</td>
            <td style="vertical-align: middle">{{$disposisi->harapan}}</td>
            <td style="vertical-align: middle;">{{$disposisi->catatan}}</td>
        </tr>
    @endforeach
</table>
</body>
</html>