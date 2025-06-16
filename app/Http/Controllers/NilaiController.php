<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\Tugas;
use App\Models\TugasKelompok;

class NilaiController extends Controller
{
    public function index()
    {
        $tugas = Tugas::with(['kelompok'])->get();
        return view('dosen.nilai', compact('tugas'));
    }

    public function edit($id)
    {
        // Ambil data tugas kelompok berdasarkan ID
        $tugasKelompok = TugasKelompok::findOrFail($id);

        return view('dosen.input_nilai', compact('tugasKelompok'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bobot' => 'required|numeric',
            'nilai' => 'required|numeric',
            'capaian_maksimal' => 'required|numeric',
            'nilai_huruf' => 'required|string|max:5',
        ]);

        // Update data di tabel tugas_kelompok
        $tugasKelompok = TugasKelompok::findOrFail($id);
        $tugasKelompok->update([
            'bobot' => $request->bobot,
            'nilai' => $request->nilai,
            'capaian_maksimal' => $request->capaian_maksimal,
            'nilai_huruf' => $request->nilai_huruf,
        ]);

        return redirect()->route('dosen.nilai.edit', $id)->with('success', 'Nilai berhasil diperbarui.');
    }
}
