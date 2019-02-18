<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\SuratDisposisi;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest:admin', 'guest:web'])->only('index');
        $this->middleware('beranda')->only('beranda');
    }

    public function index()
    {
        $carousels = Carousel::all();

        return view('welcome', compact('carousels'));
    }

    public function beranda()
    {
        $newUser = User::where('created_at', '>=', today()->subDays('3')->toDateTimeString())->count();
        $newSm = SuratMasuk::where('created_at', '>=', today()->subDays('3')->toDateTimeString())->count();
        $newSd = SuratDisposisi::where('created_at', '>=', today()->subDays('3')->toDateTimeString())->count();
        $newSk = SuratKeluar::where('created_at', '>=', today()->subDays('3')->toDateTimeString())->count();

        $users = User::all();
        $masuks = SuratMasuk::all();
        $disposisis = SuratDisposisi::all();
        $keluars = SuratKeluar::all();

        return view('beranda', compact('newUser', 'newSm', 'newSd', 'newSk',
            'users', 'masuks', 'disposisis', 'keluars'));
    }

    public function showLampiran($surat, $id)
    {
        if ($surat == 'masuk') {
            $files = SuratMasuk::find($id)->files;
        } else {
            $files = SuratKeluar::find($id)->files;
        }

        return $files;
    }
}
