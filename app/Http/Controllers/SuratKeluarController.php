<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade as PDF;
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
        $keluars = SuratKeluar::orderByDesc('id')->get();
        $types = JenisSurat::all();
        $no_urut = str_pad(SuratKeluar::count() + 1, 3, '0', STR_PAD_LEFT);
        $findSurat = $request->q;

        return view('surat.keluar', compact('keluars', 'types', 'no_urut', 'findSurat'));
    }

    public function pdfSuratKeluar($id)
    {
        $kadin = User::where('role', Role::KADIN)->first();
        $sk = SuratKeluar::find(decrypt($id));

        if ($sk->jenis_id == 5 || $sk->jenis_id == 6 || $sk->jenis_id == 10 ||
            $sk->jenis_id == 11 || $sk->jenis_id == 12 || $sk->jenis_id == 21) {
            return view('surat.template-sk.nd-npkn-sb-si-sk-su', compact('sk', 'kadin'));

        } elseif ($sk->jenis_id == 16) {
            return view('surat.template-sk.sp', compact('sk', 'kadin'));

        } elseif ($sk->jenis_id == 8 || $sk->jenis_id == 18 || $sk->jenis_id == 19) {
            return view('surat.template-sk.spt-sppd-r', compact('sk', 'kadin'));
        }

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

        return back()->with('success', 'Surat keluar (' . $sk->getJenisSurat->jenis . ') berhasil dibuat!');
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

            return back()->with('success', 'Surat keluar (' . $sk->getJenisSurat->jenis . ') berhasil diperbarui!');

        } elseif (Auth::user()->isPengolah()) {
            $sk->update([
                'tgl_surat' => $request->tgl_surat,
                'no_surat' => $request->no_surat,
                'sifat_surat' => $request->sifat_surat,
                'lampiran' => $request->lampiran . ' lembar',
                'isi' => $request->isi,
                'tembusan' => $request->tembusan,
                'status' => 1,
            ]);

            return back()->with('success', 'Surat keluar #' . $sk->no_surat . ' berhasil diperbarui!');

        } elseif (Auth::user()->isKadin()) {
            if ($request->check_form == 'ajukan') {
                $sk->update([
                    'user_id' => Auth::id(),
                    'jenis_id' => $request->jenis_id,
                    'nama_penerima' => $request->nama_penerima,
                    'kota_penerima' => $request->kota_penerima,
                    'perihal' => $request->perihal,
                    'status' => 0,
                ]);

                return back()->with('success', 'Surat keluar (' . $sk->getJenisSurat->jenis . ') berhasil diperbarui!');

            } elseif ($request->check_form == 'validasi') {
                $sk->update([
                    'status' => $request->rb_status,
                    'catatan' => $request->catatan,
                ]);

                $status = $sk->status == 2 ? 'divalidasi!' : 'diperbarui!';
                return back()->with('success', 'Surat keluar #' . $sk->no_surat . ' berhasil ' . $status);
            }
        }
    }

    public function deleteSuratKeluar($id)
    {
        $sk = SuratKeluar::find(decrypt($id));
        $sk->delete();

        return back()->with('success', 'Surat keluar (' . $sk->getJenisSurat->jenis . ') berhasil dihapus!');
    }

    public function konfirmasiSuratKeluar($id)
    {
        $sk = SuratKeluar::find($id);
        $sk->update(['status' => 5]);

        return back()->with('success', 'Pengambilan surat keluar #' . $sk->no_surat . ' berhasil dikonfirmasi!');
    }
}
