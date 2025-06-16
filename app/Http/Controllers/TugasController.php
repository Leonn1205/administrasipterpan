<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\TugasKelompok;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TugasController extends Controller
{
    public function index()
    {
        $dosen = Auth::user()->dosen;

        if (!$dosen) {
            return redirect()->back()->with('debug', 'Data dosen tidak ditemukan.');
        }

        $tugas = Tugas::where('id_dosen', $dosen->id_dosen)->get();
        return view('dosen.tugas', compact('tugas'));
    }

    public function create()
    {
        return view('dosen.tambah_tugas');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'mulai' => 'required|date',
            'kumpul_sblm' => 'required|date',
            'file_tugas_dosen' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $dosen = Auth::user()->dosen;

        $filePath = null;
        if ($request->hasFile('file_tugas_dosen')) {
            $file = $request->file('file_tugas_dosen');
            $fileName = str_replace(' ', '_', $request->input('judul')) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('tugas_dosen', $fileName, 'public');
        }

        // Simpan tugas ke database
        $tugas = Tugas::create([
            'id_dosen' => $dosen->id_dosen,
            'judul' => $request->input('judul'),
            'mulai' => $request->input('mulai'),
            'kumpul_sblm' => $request->input('kumpul_sblm'),
            'file_tugas_dosen' => $filePath,
        ]);

        // Tambahkan tugas ke semua kelompok yang sudah ada
        $kelompokList = \App\Models\Kelompok::all();
        foreach ($kelompokList as $kelompok) {
            DB::table('tugas_kelompok')->insert([
                'id_klp' => $kelompok->id_klp,
                'id_tugas' => $tugas->id_tugas,
                'file_tugas_mhs' => null,
                'waktu_kumpul' => null,
            ]);
        }

        return redirect()->route('dosen.tugas')->with('success', 'Tugas berhasil ditambahkan dan ditautkan ke semua kelompok.');
    }


    public function download($id, $id_klp)
    {
        $tugas = Tugas::findOrFail($id);
        $kelompok = $tugas->kelompok()->where('kelompok.id_klp', $id_klp)->first();

        if (!$kelompok || !$kelompok->pivot->file_tugas_mhs) {
            abort(404, 'File tidak ditemukan.');
        }

        $file = $kelompok->pivot->file_tugas_mhs;
        $path = storage_path('app/file_tugas/' . $file);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        // Ambil NIM dari mahasiswa1 (atau mahasiswa2 jika kamu mau)
        $nim = $kelompok->mahasiswa1->nim ?? 'tidak_diketahui';

        // Ambil ekstensi file
        $ext = pathinfo($file, PATHINFO_EXTENSION);

        return response()->download($path, $nim . '.' . $ext);
    }

    public function peserta($id)
    {
        $tugas = Tugas::with('kelompok.mahasiswa1', 'kelompok.mahasiswa2')->findOrFail($id);

        return view('dosen.peserta_tugas', compact('tugas'));
    }

    public function updateNilai(Request $request, $id_tugas)
    {
        $request->validate([
            'id_kelompok' => 'required|exists:tugas_kelompok,id',
            'nilai' => 'required|numeric|min:0|max:100',
            'bobot' => 'required|numeric|min:0|max:100',
        ]);

        // Cari data tugas kelompok berdasarkan ID
        $tugasKelompok = TugasKelompok::findOrFail($request->id_kelompok);

        // Hitung nilai huruf berdasarkan nilai angka
        $nilaiAngka = $request->nilai;
        if ($nilaiAngka >= 85) {
            $nilaiHuruf = 'A';
        } elseif ($nilaiAngka >= 70) {
            $nilaiHuruf = 'B';
        } elseif ($nilaiAngka >= 60) {
            $nilaiHuruf = 'C';
        } elseif ($nilaiAngka >= 50) {
            $nilaiHuruf = 'D';
        } else {
            $nilaiHuruf = 'E';
        }

        // Update nilai untuk kelompok saat ini
        $tugasKelompok->update([
            'nilai' => $nilaiAngka,
            'bobot' => $request->bobot,
            'nilai_huruf' => $nilaiHuruf,
        ]);

        // Hitung rata-rata nilai semua kelompok untuk tugas ini
        $rataRataNilai = TugasKelompok::where('id_tugas', $id_tugas)->avg('nilai');

        // Update capaian maksimal di tabel tugas_kelompok
        DB::table('tugas_kelompok')->where('id_tugas', $id_tugas)->update([
            'capaian_maksimal' => $rataRataNilai,
        ]);

        return redirect()->route('dosen.tugas.peserta', $id_tugas)
                        ->with('success', 'Nilai berhasil disimpan dan capaian maksimal diperbarui.');
    }

    public function detail($id)
    {
        $tugas = Tugas::findOrFail($id);

        return view('dosen.detail_tugas', compact('tugas'));
    }
}
