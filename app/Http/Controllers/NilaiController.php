<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\Tugas;

class NilaiController extends Controller
{
    public function index()
    {
        $tugas = Tugas::with(['kelompok'])->get();
        return view('dosen.nilai', compact('tugas'));
    }

    // public function update(Request $request, $id)
    // {
    //     // Validasi data
    //     $request->validate([
    //         'nilai' => 'required|numeric|min:0|max:100',
    //     ]);

    //     // Update nilai mahasiswa
    //     $nilai = Nilai::findOrFail($id);
    //     $nilai->update(['nilai' => $request->nilai]);

    //     return redirect()->route('dosen.nilai')->with('success', 'Nilai berhasil diperbarui.');
    // }
}
