<?php

namespace App\Http\Controllers;
use App\Models\Kelompok;
use App\Models\Dosen;

use Illuminate\Http\Request;

class KoordinatorController extends Controller
{
    public function dashboard()
    {
        $kelompok = Kelompok::with(['mahasiswa1', 'mahasiswa2'])->get();
        $dosenList = Dosen::all();
        return view('koordinator.dashboard', compact('kelompok', 'dosenList'));
    }

    public function updatePembimbing(Request $request)
    {
        foreach ($request->pembimbing as $id_klp => $id_dosen) {
            Kelompok::where('id_klp', $id_klp)->update(['id_dosen' => $id_dosen]);
        }
        return redirect()->back()->with('success', 'Pembimbing berhasil diperbarui!');
    }
}
