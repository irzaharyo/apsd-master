<?php

namespace App\Http\Controllers\Admins;

use App\Models\Carousel;
use App\Models\JenisSurat;
use App\Models\PerihalSurat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class WebContentsController extends Controller
{
    public function showCarouselsTable()
    {
        $carousels = Carousel::all();

        return view('_admins.webContents.carousel-table', compact('carousels'));
    }

    public function createCarousels(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,jpeg,gif,png|max:1024',
            'captions' => 'required|string|max:191',
        ]);

        $name = $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('images\carousel'), $name);

        Carousel::create([
            'image' => $name,
            'captions' => $request->captions,
        ]);

        return back()->with('success', 'Carousel (' . Str::words($request->caption, 10, '...') .
            ') berhasil dibuat!');
    }

    public function updateCarousels(Request $request)
    {
        $carousel = Carousel::find($request->id);

        $this->validate($request, [
            'image' => 'image|mimes:jpg,jpeg,gif,png|max:1024',
            'captions' => 'required|string|max:191',
        ]);

        if ($request->hasfile('image')) {
            $name = $request->file('image')->getClientOriginalName();
            if ($carousel->image != '') {
                unlink(public_path('images\carousel/' . $carousel->image));
            }
            $request->file('image')->move(public_path('images\carousel'), $name);

        } else {
            $name = $carousel->image;
        }

        $carousel->update([
            'image' => $name,
            'captions' => $request->captions,
        ]);

        return back()->with('success', 'Carousel (' . Str::words($carousel->caption, 10, '...') .
            ') berhasil diperbarui!');
    }

    public function deleteCarousels($id)
    {
        $carousel = Carousel::find(decrypt($id));
        if ($carousel->image != '') {
            unlink(public_path('images\carousel/' . $carousel->image));
        }
        $carousel->delete();

        return back()->with('success', 'Carousel (' . Str::words($carousel->caption, 10, '...') .
            ') berhasil dihapus!');
    }

    public function showJenisSuratTable()
    {
        $jenis_surats = JenisSurat::all();

        return view('_admins.webContents.jenis_surat-table', compact('jenis_surats'));
    }

    public function createJenisSurat(Request $request)
    {
        JenisSurat::create([
            'jenis' => $request->jenis,
        ]);

        return back()->with('success', 'Jenis surat (' . $request->jenis . ') berhasil dibuat!');
    }

    public function updateJenisSurat(Request $request)
    {
        $jenis_surat = JenisSurat::find($request->id);
        $jenis_surat->update([
            'name' => $request->name,
            'caption' => $request->caption
        ]);

        return back()->with('success', 'Jenis surat (' . $jenis_surat->name . ') berhasil diperbarui!');
    }

    public function deleteJenisSurat($id)
    {
        $jenis_surat = JenisSurat::find(decrypt($id));
        $jenis_surat->delete();

        return back()->with('success', 'Jenis surat (' . $jenis_surat->name . ') berhasil dihapus!');
    }

    public function showPerihalSuratTable()
    {
        $perihal_surats = PerihalSurat::all();

        return view('_admins.webContents.perihal_surat-table', compact('perihal_surats'));
    }

    public function createPerihalSurat(Request $request)
    {
        PerihalSurat::create([
            'kode' => $request->kode,
            'perihal' => $request->perihal,
        ]);

        return back()->with('success', 'Perihal surat #' . $request->kode . ' berhasil dibuat!');
    }

    public function updatePerihalSurat(Request $request)
    {
        $perihal_surat = PerihalSurat::find($request->id);
        $perihal_surat->update([
            'kode' => $request->kode,
            'perihal' => $request->perihal
        ]);

        return back()->with('success', 'Perihal surat #' . $perihal_surat->kode . ' berhasil diperbarui!');
    }

    public function deletePerihalSurat($id)
    {
        $perihal_surat = PerihalSurat::find(decrypt($id));
        $perihal_surat->delete();

        return back()->with('success', 'Perihal surat #' . $perihal_surat->kode . ' berhasil dihapus!');
    }
}
