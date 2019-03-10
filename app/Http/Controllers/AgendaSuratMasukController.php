<?php

namespace App\Http\Controllers;

use App\Models\AgendaMasuk;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class AgendaSuratMasukController extends Controller
{
    public function showAgenda(Request $request)
    {
        $agenda_masuks = AgendaMasuk::orderByDesc('id')->get();
        $surat_masuks = SuratMasuk::whereHas('getSuratDisposisi', function ($q) {
            $q->doesnthave('getAgendaMasuk');
        })->orderByDesc('id')->get();
        $findSurat = SuratMasuk::where('no_surat', $request->q)->first();

        return view('agenda.masuk', compact('agenda_masuks', 'surat_masuks', 'findSurat'));
    }

    public function createAgenda(Request $request)
    {
        $sm = SuratMasuk::find($request->surat_masuk);
        AgendaMasuk::create([
            'suratdisposisi_id' => $sm->getSuratDisposisi->id,
            'ringkasan' => $request->ringkasan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('show.agenda-masuk')->with('success', 'Agenda surat masuk #' .
            $sm->no_surat . ' berhasil dibuat!');
    }

    public function editAgenda(Request $request)
    {
        return AgendaMasuk::find($request->id);
    }

    public function updateAgenda(Request $request)
    {
        $agm = AgendaMasuk::find($request->id);
        $agm->update([
            'ringkasan' => $request->ringkasan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('show.agenda-masuk')->with('success', 'Agenda surat masuk #' .
            $agm->getSuratDisposisi->getSuratMasuk->no_surat . ' berhasil diperbarui!');
    }

    public function deleteAgenda($id)
    {
        $agm = AgendaMasuk::find(decrypt($id));
        $agm->delete();

        return redirect()->route('show.agenda-masuk')->with('success', 'Agenda surat masuk #' .
            $agm->getSuratDisposisi->getSuratMasuk->no_surat . ' berhasil dihapus!');
    }
}
