<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class SuratMasukController extends Controller
{
    public function showSuratMasuk()
    {
        $masuks = SuratMasuk::all();
        return view('surat.masuk', compact('masuks'));
    }

    public function deleteSuratMasuk($id)
    {
        $surat = SuratMasuk::find(decrypt($id));
        $surat->delete();

        return back()->with('delete', 'Surat Masuk #' . $surat->no_surat . ' berhasil dihapus!');
    }
}
