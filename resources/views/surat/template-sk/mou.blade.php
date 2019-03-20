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
            size: 8.5in 14in;
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
    <div class="kop">
        <img src="{{asset('images/kop.png')}}" alt="kop" class="img-responsive kop_icon">
        <h3 style="text-transform: uppercase;margin: 0 auto">PEMERINTAH KOTA MADIUN</h3>
        <h2 style="text-transform: uppercase;margin: 0 auto">DINAS PERTANIAN DAN KETAHANAN PANGAN</h2>
        <p style="margin: 0 auto 0 auto">Jalan Tirta Raya Nomor 15 Madiun Kode Pos 63129<br>Telepon (0351) 455855 Fax
            (0351) 455855<br><u>Email : dipertakotamadiun@gmail.com</u></p>
    </div>
    <hr class="thin">
    <hr class="thick">
    <div class="detail">
        <p align="center" style="text-transform: uppercase;font-weight: 600;">
            perjanjian kerjasama<br><span style="font-weight: normal;line-height: 1.5">antara</span><br>
            dinas pertanian dan ketahanan pangan<br>kota madiun<br><span style="font-weight: normal;line-height: 1.5">dengan</span><br>
            {{$sk->jabatan_penerima.' '.$sk->instansi_penerima}}<br>Kota {{$sk->kota_penerima}}<br>
            <span style="font-weight: normal;line-height: 2.5">tentang</span><br>{{$sk->perihal}}
        </p>
        <p align="center" style="text-transform: uppercase;">
            NOMOR PIHAK PERTAMA: {{$sk->no_surat}}<br>NOMOR PIHAK KEDUA: {{$sk->no_surat}}
        </p>
    </div>
</header>

<section>{!! $sk->isi !!}</section>

<footer>
    <div class="ttd">
        <table>
            <tr>
                <td width="50%">
                    <table>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>PIHAK KEDUA</td>
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
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>PIHAK PERTAMA</td>
                        </tr>
                        <tr>
                            <td style="text-transform: uppercase ; font-weight: 600">{{$kadin->jabatan}}<br>kota madiun
                            </td>
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