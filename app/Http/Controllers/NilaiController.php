<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TugasKelompok;

class NilaiController extends Controller
{
    public function index()
    {
        $tugas = \App\Models\Tugas::all();

        return view('dosen.nilai', compact('tugas'));
    }

    // Form edit nilai
    public function edit($id)
    {
        $tugasKelompok = TugasKelompok::with('tugas', 'kelompok.mahasiswa1', 'kelompok.mahasiswa2')->findOrFail($id);
        return view('dosen.nilai.input_nilai', compact('tugasKelompok'));
    }

    // Simpan/update nilai
    public function update(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        $tugasKelompok = TugasKelompok::with('tugas')->findOrFail($id);
        $bobot = $tugasKelompok->tugas->bobot;

        // Hitung nilai akhir berdasarkan bobot
        $nilaiAngka = $request->nilai;
        $nilaiAkhir = $nilaiAngka * ($bobot / 100);

        // Konversi ke huruf
        $nilaiHuruf = match (true) {
            $nilaiAngka >= 85 => 'A',
            $nilaiAngka >= 70 => 'B',
            $nilaiAngka >= 60 => 'C',
            $nilaiAngka >= 50 => 'D',
            default => 'E',
        };

        // Update ke tabel tugas_kelompok
        $tugasKelompok->update([
            'nilai' => $nilaiAkhir,
            'nilai_huruf' => $nilaiHuruf,
        ]);

        // Hitung rata-rata nilai akhir untuk tugas ini sebagai capaian maksimal
        $rataRata = TugasKelompok::where('id_tugas', $tugasKelompok->id_tugas)->avg('nilai');

        // Update capaian maksimal untuk semua kelompok
        TugasKelompok::where('id_tugas', $tugasKelompok->id_tugas)->update([
            'capaian_maksimal' => $rataRata,
        ]);

        return redirect()->route('dosen.nilai.edit', $id)->with('success', 'Nilai berhasil diperbarui.');
    }
}
