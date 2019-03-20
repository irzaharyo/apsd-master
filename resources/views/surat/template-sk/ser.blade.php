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
            size: A4;
        }

        body {
            font-family: Tahoma;
        }

        .wrapper {
            height: 980px;
            padding: 0 1.5em;
            display: table-cell;
            vertical-align: middle;
            border: 25px solid #307a4b;
            border-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='75' height='75'%3E%3Cg fill='none' stroke='%23307a4b' stroke-width='2'%3E%3Cpath d='M1 1h73v73H1z'/%3E%3Cpath d='M8 8h59v59H8z'/%3E%3Cpath d='M8 8h16v16H8zM51 8h16v16H51zM51 51h16v16H51zM8 51h16v16H8z'/%3E%3C/g%3E%3Cg fill='%23307a4b'%3E%3Ccircle cx='16' cy='16' r='2'/%3E%3Ccircle cx='59' cy='16' r='2'/%3E%3Ccircle cx='59' cy='59' r='2'/%3E%3Ccircle cx='16' cy='59' r='2'/%3E%3C/g%3E%3C/svg%3E") 25;
        }

        .kop {
            margin: 0 auto -20px auto;
            text-align: center;
        }

        .kop_icon {
            width: 150px;
            margin: 0 auto;
        }

        .title {
            font-family: "Old English Text MT";
            font-size: 72px;
            text-align: center;
            font-weight: 500;
            margin-bottom: -20px;
        }

        .detail {
            margin-bottom: 2.5em;
        }

        table {
            width: 100%;
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
<div class="wrapper">
    <header>
        <div class="kop">
            <img src="{{asset('images/Kota%20Madiun.png')}}" alt="kop" class="img-responsive kop_icon">
            <h2 style="text-transform: uppercase;margin: 0 auto">DINAS PERTANIAN DAN KETAHANAN PANGAN<br>KOTA MADIUN
            </h2>
        </div>
        <h1 class="title">Sertifikat</h1>
        <div class="detail">
            <p align="center">Nomor: {{$sk->no_surat}}</p>
        </div>
    </header>

    <section style="margin-bottom: 2.5em">{!! $sk->isi !!}</section>

    <footer>
        <div class="ttd">
            <table>
                <tr>
                    <td width="60%">&nbsp;</td>
                    <td width="40%">Madiun, {{strftime('%d %B %Y', strtotime($sk->tgl_surat))}}</td>
                </tr>
                <tr>
                    <td width="60%">&nbsp;</td>
                    <td width="40%" style="text-transform: uppercase ; font-weight: 600">{{$kadin->jabatan}}<br>kota
                        madiun
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
</div>
</body>
</html>