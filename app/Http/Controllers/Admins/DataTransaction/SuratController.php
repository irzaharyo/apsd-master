<?php

namespace App\Http\Controllers\Admins\DataTransaction;

use App\Models\SuratDisposisi;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;

class SuratController extends Controller
{
    public function showSuratMasuk()
    {
        $masuks = SuratMasuk::orderByDesc('id')->get();

        return view('_admins.dataTransaction.surat_masuk-table', compact('masuks'));
    }

    public function massPdfSuratMasuk($ids)
    {
        $sm_ids = explode(",", $ids);
        $masuks = SuratMasuk::whereIn('id', $sm_ids)->get();

        $pdf = PDF::loadView('reports.surat_masuk-pdf', compact('masuks'))->setPaper('a4', 'landscape');
        return $pdf->stream('DaftarSuratMasuk.pdf');
    }

    public function massDeleteSuratMasuk(Request $request)
    {
        $masuks = SuratMasuk::whereIn('id', explode(",", $request->sm_ids))->get();

        foreach ($masuks as $masuk) {
            $masuk->delete();
        }

        return back()->with('success', '' . count($masuks) . ' surat masuk berhasil dihapus!');
    }

    public function showSuratDisposisi()
    {
        $masuks = SuratMasuk::orderByDesc('id')->get();
        $disposisis = SuratDisposisi::orderByDesc('id')->get();

        return view('_admins.dataTransaction.surat_disposisi-table', compact('masuks', 'disposisis'));
    }

    public function massPdfSuratDisposisi($ids)
    {
        $sd_ids = explode(",", $ids);
        $disposisis = SuratDisposisi::whereIn('id', $sd_ids)->get();

        $pdf = PDF::loadView('reports.surat_disposisi-pdf', compact('disposisis'))->setPaper('a4', 'landscape');
        return $pdf->stream('DaftarSuratDisposisi.pdf');
    }

    public function massDeleteSuratDisposisi(Request $request)
    {
        $disposisis = SuratDisposisi::whereIn('id', explode(",", $request->sd_ids))->get();

        foreach ($disposisis as $disposisi) {
            $disposisi->delete();
        }

        return back()->with('success', '' . count($disposisis) . ' surat disposisi berhasil dihapus!');
    }

    public function showSuratKeluar()
    {
        $keluars = SuratKeluar::orderByDesc('id')->get();

        return view('_admins.dataTransaction.surat_keluar-table', compact('keluars'));
    }

    public function massPdfSuratKeluar($ids)
    {
        $sk_ids = explode(",", $ids);
        $keluars = SuratKeluar::whereIn('id', $sk_ids)->get();

        $pdf = PDF::loadView('reports.surat_keluar-pdf', compact('keluars'))->setPaper('a4', 'landscape');
        return $pdf->stream('DaftarSuratKeluar.pdf');
    }

    public function massDeleteSuratKeluar(Request $request)
    {
        $keluars = SuratKeluar::whereIn('id', explode(",", $request->sk_ids))->get();

        foreach ($keluars as $keluar) {
            $keluar->delete();
        }

        return back()->with('success', '' . count($keluars) . ' surat keluar berhasil dihapus!');
    }
}
