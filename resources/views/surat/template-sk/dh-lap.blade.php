<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env('APP_NAME')}} &ndash; Aplikasi Pengarsipan Surat dan Disposisi | Dinas Pertanian dan Ketahanan Pangan
        Kota Madiun</title>
    <style>
        @media print {
            a[href]:after {
                content: none !important;
            }
        }

        @page {
            size: 8.5in 14in landscape;
        }

        body {
            font-family: Tahoma;
        }

        .kop {
            margin: 0 auto;
            text-align: center;
        }

        .kop_icon {
            float: left;
            width: 85px;
        }

        hr.thin {
            border: 1px solid #000;
            margin-bottom: -5px
        }

        hr.thick {
            border: 3px solid #000;
        }

        table {
            width: 100%;
        }

        p.penerima {
            margin-bottom: -15px;
            padding-left: 35px;
        }

        p.penerima:first-letter {
            margin-left: -35px;
        }

        .ttd {
            text-align: center;
            margin: 1.5em auto;
        }

        .tembusan ul, .tembusan ol {
            margin-top: 0;
        }
    </style>
</head>
<body onload="window.print()">
<header>
    <div class="detail">
        <h4 style="text-transform: uppercase;text-align: center;font-weight: 600">{{$sk->perihal}}</h4>
    </div>
</header>

<section>{!! $sk->isi !!}</section>

<footer>
    <div class="ttd">
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
    </div>
    @if($sk->tembusan != "")
        <div class="tembusan">
            Tembusan :<br>
            {!! $sk->tembusan !!}
        </div>
    @endif
</footer>
</body>
</html>