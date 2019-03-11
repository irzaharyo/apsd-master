<?php

namespace App\Http\Controllers\Admins\DataMaster;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class AccountsController extends Controller
{
    public function showAdminsTable()
    {
        $admins = Admin::orderByDesc('id')->get();

        return view('_admins.dataMaster.admin-table', compact('admins'));
    }

    public function createAdmins(Request $request)
    {
        $this->validate($request, [
            'ava' => 'image|mimes:jpg,jpeg,gif,png|max:2048',
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:admins',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required'
        ]);

        if ($request->hasfile('ava')) {
            $name = $request->file('ava')->getClientOriginalName();
            $request->file('ava')->storeAs('public/admins', $name);

        } else {
            $name = 'avatar.png';
        }

        Admin::create([
            'ava' => $name,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);

        return back()->with('success', 'Akun admin (' . $request->name . ') berhasil ditambahkan!');
    }

    public function updateProfileAdmins(Request $request)
    {
        $admin = Admin::find($request->id);
        $this->validate($request, [
            'ava' => 'image|mimes:jpg,jpeg,gif,png|max:2048',
        ]);
        if ($request->hasFile('ava')) {
            $name = $request->file('ava')->getClientOriginalName();
            if ($admin->ava != '' || $admin->ava != 'avatar.png') {
                Storage::delete('public/admins/' . $admin->ava);
            }
            $request->file('ava')->storeAs('public/admins', $name);

        } else {
            $name = $admin->ava;
        }
        $admin->update([
            'ava' => $name,
            'name' => $request->name
        ]);

        return back()->with('success', 'Profil admin (' . $admin->name . ') berhasil diperbarui!');
    }

    public function updateAccountAdmins(Request $request)
    {
        $admin = Admin::find($request->id);

        if (!Hash::check($request->password, $admin->password)) {
            return back()->with('error', 'Password lama akun admin (' . $admin->name . ') salah!');

        } else {
            if ($request->new_password != $request->password_confirmation) {
                return back()->with('error', 'Password baru dan konfirmasi password akun admin (' . $admin->name .
                    ') tidak cocok!');

            } else {
                $admin->update([
                    'email' => $request->email,
                    'password' => bcrypt($request->new_password),
                    'role' => $request->role == null ? 'root' : $request->role
                ]);
                return back()->with('success', 'Akun admin (' . $admin->name . ') berhasil diperbarui!');
            }
        }
    }

    public function deleteAdmins($id)
    {
        $admin = Admin::find(decrypt($id));
        if ($admin->ava != '' || $admin->ava != 'avatar.png') {
            Storage::delete('public/admins/' . $admin->ava);
        }
        $admin->forceDelete();

        return back()->with('success', 'Akun admin (' . $admin->name . ') berhasil dihapus!');
    }

    public function showUsersTable()
    {
        $users = User::orderByDesc('id')->get();

        return view('_admins.dataMaster.user-table', compact('users'));
    }

    public function createUsers(Request $request)
    {
        if ($request->hasfile('ava')) {
            $this->validate($request, ['ava' => 'image|mimes:jpg,jpeg,gif,png|max:2048',]);

            $name = $request->file('ava')->getClientOriginalName();
            $request->file('ava')->storeAs('public/users', $name);
        } else {
            $name = 'avatar.png';
        }

        $address = str_replace(" ", "+", $request->alamat);
        $json = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=" .
            $address . "&key=AIzaSyBIljHbKjgtTrpZhEiHum734tF1tolxI68");
        $request->request->add([
            'lat' => json_decode($json)->{'results'}[0]->{'geometry'}->{'location'}->{'lat'},
            'long' => json_decode($json)->{'results'}[0]->{'geometry'}->{'location'}->{'lng'}
        ]);

        User::create([
            'ava' => $name,
            'nip' => $request->nip,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'jabatan' => $request->jabatan,
            'nmr_hp' => $request->nmr_hp,
            'jk' => $request->jk,
            'alamat' => $request->alamat,
            'lat' => $request->lat,
            'long' => $request->long,
        ]);

        return back()->with('success', 'Akun ' . $request->role . ' (' . $request->name . ') berhasil ditambahkan!');
    }

    public function updateProfileUsers(Request $request)
    {
        $user = User::find($request->id);
        $this->validate($request, ['ava' => 'image|mimes:jpg,jpeg,gif,png|max:2048',]);
        if ($request->hasFile('ava')) {
            $name = $request->file('ava')->getClientOriginalName();
            if ($user->ava != '' || $user->ava != 'avatar.png') {
                Storage::delete('public/users/' . $user->ava);
            }
            $request->file('ava')->storeAs('public/users', $name);
        } else {
            $name = $user->ava;
        }

        $address = str_replace(" ", "+", $request->alamat);
        $json = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=" .
            $address . "&key=AIzaSyBIljHbKjgtTrpZhEiHum734tF1tolxI68");
        $request->request->add([
            'lat' => json_decode($json)->{'results'}[0]->{'geometry'}->{'location'}->{'lat'},
            'long' => json_decode($json)->{'results'}[0]->{'geometry'}->{'location'}->{'lng'}
        ]);

        $user->update([
            'ava' => $name,
            'nip' => $request->nip,
            'name' => $request->name,
            'jabatan' => $request->jabatan,
            'nmr_hp' => $request->nmr_hp,
            'jk' => $request->jk,
            'alamat' => $request->alamat,
            'lat' => $request->lat,
            'long' => $request->long,
        ]);

        return back()->with('success', 'Profil ' . $user->role . ' (' . $user->name . ') berhasil diperbarui!');
    }

    public function updateAccountUsers(Request $request)
    {
        $user = User::find($request->id);

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password lama akun ' . $user->role . '(' . $user->name . ') salah!');

        } else {
            if ($request->new_password != $request->password_confirmation) {
                return back()->with('error', 'Password baru dan konfirmasi password akun ' . $user->role .
                    '(' . $user->name . ') tidak cocok!');

            } else {
                $user->update([
                    'email' => $request->email,
                    'password' => bcrypt($request->new_password),
                    'role' => $request->role
                ]);
                return back()->with('success', 'Akun ' . $user->role . ' (' . $user->name . ') berhasil diperbarui!');
            }
        }
    }

    public function deleteUsers($id)
    {
        $user = User::find(decrypt($id));
        if ($user->ava != '' || $user->ava != 'seeker.png' || $user->ava != 'agency.png') {
            Storage::delete('public/users/' . $user->ava);
        }
        $user->forceDelete();

        return back()->with('success', 'Akun ' . $user->role . ' (' . $user->name . ') berhasil dihapus!');
    }
}
