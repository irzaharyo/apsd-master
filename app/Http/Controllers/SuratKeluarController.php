<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use App\Models\SuratKeluar;
use App\Models\User;
use App\Support\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuratKeluarController extends Controller
{
    public function showSuratKeluar(Request $request)
    {
        if (Auth::user()->isPegawai()) {
            $keluars = SuratKeluar::whereIn('user_id', [Auth::id(), User::where('role', Role::KADIN)
                ->first()->id])->orderByDesc('id')->get();
        } else {
            $keluars = SuratKeluar::orderByDesc('id')->get();
        }
        $types = JenisSurat::all();
        $no_urut = str_pad(SuratKeluar::count() + 1, 3, '0', STR_PAD_LEFT);
        $findSurat = $request->q;

        return view('surat.keluar', compact('keluars', 'types', 'no_urut', 'findSurat'));
    }

    public function showPdfSuratKeluar($id)
    {
        $sk = SuratKeluar::find(decrypt($id));

        return view('surat.print', compact('sk'));
    }

    public function createSuratKeluar(Request $request)
    {
        $sk = SuratKeluar::create([
            'user_id' => Auth::id(),
            'jenis_id' => $request->jenis_id,
            'nama_penerima' => $request->nama_penerima,
            'kota_penerima' => $request->kota_penerima,
            'perihal' => $request->perihal,
            'status' => 0,
        ]);

        return back()->with('success', 'Surat keluar untuk ' . $sk->nama_penerima . ', ' . $sk->kota_penerima .
            ' berhasil dibuat!');
    }

    public function editSuratKeluar($id)
    {
        return SuratKeluar::find($id);
    }

    public function updateSuratKeluar(Request $request)
    {
        $sk = SuratKeluar::find($request->id);
        if (Auth::user()->isPegawai()) {
            $sk->update([
                'user_id' => Auth::id(),
                'jenis_id' => $request->jenis_id,
                'nama_penerima' => $request->nama_penerima,
                'kota_penerima' => $request->kota_penerima,
                'perihal' => $request->perihal,
                'status' => 0,
            ]);

            return back()->with('success', 'Surat keluar untuk ' . $sk->nama_penerima . ', ' . $sk->kota_penerima .
                ' berhasil diperbarui!');

        } elseif (Auth::user()->isPengolah()) {
            $sk->update([
                'tgl_surat' => $request->tgl_surat,
                'no_surat' => $request->no_surat,
                'sifat_surat' => $request->sifat_surat,
                'lampiran' => $request->lampiran,
                'isi' => $request->isi,
                'tembusan' => $request->tembusan,
                'status' => 1,
            ]);

            return back()->with('success', 'Surat keluar #' . $sk->no_surat . ' berhasil diperbarui!');

        } elseif (Auth::user()->isKadin()) {
            $sk->update([
                'status' => $request->rb_status,
                'catatan' => $request->catatan,
            ]);

            $status = $sk->status == 2 ? 'divalidasi!' : 'diperbarui!';
            return back()->with('success', 'Surat keluar #' . $sk->no_surat . ' berhasil ' . $status);
        }
    }

    public function deleteSuratKeluar($id)
    {
        $sk = SuratKeluar::find(decrypt($id));
        $sk->delete();

        return back()->with('success', 'Surat keluar untuk ' . $sk->nama_penerima . ', ' . $sk->kota_penerima .
            ' berhasil dihapus!');
    }

    public function konfirmasiSuratKeluar($id)
    {
        $sk = SuratKeluar::find($id);
        $sk->update(['status' => 5]);

        return back()->with('success', 'Pengambilan surat keluar #' . $sk->no_surat . ' berhasil dikonfirmasi!');
    }
}
