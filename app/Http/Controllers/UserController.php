<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Carousel;
use App\Models\PerihalSurat;
use App\Models\SuratDisposisi;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
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
        $masuks = SuratMasuk::orderByDesc('id')->get();
        $disposisis = SuratDisposisi::all();
        $keluars = SuratKeluar::orderByDesc('id')->get();

        return view('beranda', compact('newUser', 'newSm', 'newSd', 'newSk',
            'users', 'masuks', 'disposisis', 'keluars'));
    }

    public function showFileSurat($surat, $id)
    {
        if ($surat == 'masuk') {
            $files = SuratMasuk::find($id)->files;
        } else {
            $files = SuratKeluar::find($id)->files;
        }

        return $files;
    }

    public function getPerihalSurat($kode)
    {
        $perihals = PerihalSurat::where('kode', 'LIKE', '%' . $kode . '%')->get();

        foreach ($perihals as $perihal) {
            $perihal->label = $perihal->kode . ' - ' . $perihal->perihal;
        }

        return $perihals;
    }

    public function showStaff()
    {
        $users = User::orderByDesc('id')->get();

        return view('staff', compact('users'));
    }

    public function showProfile($role, $id)
    {
        $user = User::find(decrypt($id));

        return view('profile', compact('user', 'role'));
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'myAva' => 'image|mimes:jpg,jpeg,gif,png|max:2048',
        ]);

        if (Auth::guard('admin')->check()) {
            $admin = Admin::find(Auth::guard('admin')->user()->id);
            if ($request->hasFile('myAva')) {
                $name = $request->file('myAva')->getClientOriginalName();
                if ($admin->ava != '' || $admin->ava != 'avatar.png') {
                    Storage::delete('public/admins/' . $admin->ava);
                }
                $request->file('myAva')->storeAs('public/admins', $name);

            } else {
                $name = $admin->ava;
            }
            $admin->update([
                'ava' => $name,
                'name' => $request->myName
            ]);

        } else {
            $user = User::find(Auth::id());
            if ($request->check_form == 'ava') {
                if ($request->hasFile('ava')) {
                    $name = $request->ava->getClientOriginalName();

                    if ($user->ava != '' || $user->ava != 'seeker.png') {
                        Storage::delete('public/users/' . $user->ava);
                    }

                    if ($request->ava->isValid()) {
                        $request->ava->storeAs('public/users', $name);
                        $user->update(['ava' => $name]);
                        return asset('storage/users/' . $name);
                    }
                }

            } elseif ($request->check_form == 'personal') {
                $user->update([
                    'nip' => $request->nip,
                    'name' => $request->nama,
                    'jabatan' => $request->jabatan,
                    'nmr_hp' => $request->nmr_hp,
                    'jk' => $request->jk,
                ]);

            } elseif ($request->check_form == 'address') {
                $address = str_replace(" ", "+", $request->alamat);
                $json = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=" .
                    $address . "&key=AIzaSyBIljHbKjgtTrpZhEiHum734tF1tolxI68");

                $request->request->add([
                    'lat' => json_decode($json)->{'results'}[0]->{'geometry'}->{'location'}->{'lat'},
                    'long' => json_decode($json)->{'results'}[0]->{'geometry'}->{'location'}->{'lng'}
                ]);

                $user->update([
                    'alamat' => $request->alamat,
                    'lat' => $request->lat,
                    'long' => $request->long,
                ]);
            }
        }

        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }

    public function updateAccount(Request $request)
    {
        $user = Auth::guard('admin')->check() ? Admin::find(Auth::guard('admin')->user()->id) :
            User::find(Auth::id());

        if (!Hash::check($request->myPassword, $user->password)) {
            return back()->with('error', 'Password lama akun Anda salah!');

        } else {
            if ($request->myNew_password != $request->myPassword_confirmation) {
                return back()->with('error', 'Password baru dan konfirmasi password akun Anda tidak cocok!');

            } else {
                $user->update([
                    'email' => $request->myEmail,
                    'password' => bcrypt($request->myNew_password)
                ]);

                return back()->with('success', 'Akun Anda berhasil diperbarui!');
            }
        }
    }
}
