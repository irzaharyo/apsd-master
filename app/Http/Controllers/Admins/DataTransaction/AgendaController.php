<?php

namespace App\Http\Controllers\Admins\DataTransaction;

use Barryvdh\DomPDF\Facade as PDF;
use App\Models\AgendaKeluar;
use App\Models\AgendaMasuk;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgendaController extends Controller
{
    public function showAgendaMasuk()
    {
        $ag_masuks = AgendaMasuk::orderByDesc('id')->get();
        $masuks = SuratMasuk::orderByDesc('id')->get();

        return view('_admins.dataTransaction.agenda_masuk-table', compact('ag_masuks', 'masuks'));
    }

    public function massPdfAgendaMasuk($ids)
    {
        $agm_ids = explode(",", $ids);
        $ag_masuks = AgendaMasuk::whereIn('id', $agm_ids)->get();

        $pdf = PDF::loadView('reports.agenda_masuk-pdf', compact('ag_masuks'))->setPaper('a4', 'landscape');
        return $pdf->stream('AgendaSuratMasuk.pdf');
    }

    public function massDeleteAgendaMasuk(Request $request)
    {
        $ag_masuks = AgendaMasuk::whereIn('id', explode(",", $request->agm_ids))->get();

        foreach ($ag_masuks as $masuk) {
            $masuk->delete();
        }

        return back()->with('success', '' . count($ag_masuks) . ' agenda surat masuk berhasil dihapus!');
    }

    public function showAgendaKeluar()
    {
        $ag_keluars = AgendaKeluar::orderByDesc('id')->get();
        $keluars = SuratKeluar::orderByDesc('id')->get();

        return view('_admins.dataTransaction.agenda_keluar-table', compact('ag_keluars', 'keluars'));
    }

    public function massPdfAgendaKeluar($ids)
    {
        $agk_ids = explode(",", $ids);
        $ag_keluars = AgendaKeluar::whereIn('id', $agk_ids)->get();

        $pdf = PDF::loadView('reports.agenda_keluar-pdf', compact('ag_keluars'))->setPaper('a4', 'landscape');
        return $pdf->stream('AgendaSuratKeluar.pdf');
    }

    public function massDeleteAgendaKeluar(Request $request)
    {
        $ag_keluars = AgendaKeluar::whereIn('id', explode(",", $request->agk_ids))->get();

        foreach ($ag_keluars as $keluar) {
            $keluar->delete();
        }

        return back()->with('success', '' . count($ag_keluars) . ' agenda surat keluar berhasil dihapus!');
    }
}
