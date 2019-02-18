<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{
    public function showSuratKeluar()
    {
        $keluars = SuratKeluar::all();
        return view('surat.keluar', compact('keluars'));
    }
}
