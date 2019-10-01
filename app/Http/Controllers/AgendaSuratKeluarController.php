<?php

namespace App\Http\Controllers;

use App\Models\AgendaKeluar;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AgendaSuratKeluarController extends Controller
{
    public function showAgenda(Request $request)
    {
        $agenda_keluars = AgendaKeluar::orderByDesc('id')->get();
        $surat_keluars = SuratKeluar::where('status', 3)->doesnthave('getAgendaKeluar')->orderByDesc('id')->get();
        $findSurat = SuratKeluar::where('no_surat', $request->q)->first();

        return view('agenda.keluar', compact('agenda_keluars', 'surat_keluars', 'findSurat'));
    }

    public function createAgenda(Request $request)
    {
        $sk = SuratKeluar::find($request->surat_keluar);
        $no_urut = str_pad(substr($sk->no_surat, 4, 3), 3, '0', STR_PAD_LEFT);
        if ($request->hasfile('files')) {
            $this->validate($request, [
                'files' => 'required|array',
                'files.*' => 'mimes:jpg,jpeg,gif,png|max:5120'
            ]);

            $c = 0;
            $files = [];
            foreach ($request->file('files') as $file) {
                $file->storeAs('public/surat-keluar/' . $no_urut, $file->getClientOriginalName());

                $files[$c] = $file->getClientOriginalName();
                $c = $c + 1;
            }

            AgendaKeluar::create([
                'suratkeluar_id' => $sk->id,
                'ringkasan' => $request->ringkasan,
                'keterangan' => $request->keterangan,
                'nama_tu' => Auth::user()->name,
            ]);

            $sk->update([
                'status' => 4,
                'files' => $files
            ]);
        }

        return redirect()->route('show.agenda-keluar')->with('success', 'Agenda surat keluar #' . $sk->no_surat .
            ' berhasil dibuat!');
    }

    public function editAgenda(Request $request)
    {
        return AgendaKeluar::find($request->id);
    }

    public function updateAgenda(Request $request)
    {
        $agk = AgendaKeluar::find($request->id);
        $agk->update([
            'ringkasan' => $request->ringkasan,
            'keterangan' => $request->keterangan,
            'nama_tu' => Auth::user()->name,
        ]);

        if ($request->hasfile('files')) {
            $this->validate($request, [
                'files' => 'required|array',
                'files.*' => 'mimes:jpg,jpeg,gif,png|max:5120'
            ]);

            $c = 0;
            $files = [];
            $no_urut = substr($agk->getSuratKeluar->no_surat, 4, 3);
            foreach ($request->file('files') as $file) {
                $file->storeAs('public/surat-keluar/' . $no_urut, $file->getClientOriginalName());

                $files[$c] = $file->getClientOriginalName();
                $c = $c + 1;
            }

            $agk->getSuratKeluar->update(['files' => $agk->getSuratKeluar->files != "" ?
                array_merge($agk->getSuratKeluar->files, $files) : $files]);
        }

        return redirect()->route('show.agenda-keluar')->with('success', 'Agenda surat keluar #' .
            $agk->getSuratKeluar->no_surat . ' berhasil diperbarui!');
    }

    public function deleteAgenda($id)
    {
        $agk = AgendaKeluar::find(decrypt($id));
        $agk->delete();
        $agk->getSuratKeluar->update(['status' => 3]);

        return redirect()->route('show.agenda-keluar')->with('success', 'Agenda surat keluar #' .
            $agk->getSuratKeluar->no_surat . ' berhasil dihapus!');
    }

    public function massDeleteFileSuratKeluar(Request $request)
    {
        $surat = SuratKeluar::find($request->id);
        $no_urut = substr($surat->no_surat, 4, 3);
        $data = implode(', ', array_diff($surat->files, $request->fileSuratKeluars));
        foreach ($request->fileSuratKeluars as $file) {
            if ($surat->files != "") {
                if (count($surat->files) == count($request->fileSuratKeluars)) {
                    Storage::deleteDirectory('public/surat-keluar/' . $no_urut);
                    $surat->update(['files' => null]);

                } else {
                    Storage::delete('public/surat-keluar/' . $no_urut . '/' . $file);
                    $surat->update(['files' => explode(", ", $data)]);
                }
            }
        }

        return redirect()->route('show.agenda-keluar')->with('success', '' . count($request->fileSuratKeluars) .
            ' file surat keluar #' . $surat->no_surat . ' berhasil dihapus!');
    }

}
