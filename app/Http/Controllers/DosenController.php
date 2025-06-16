<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelompok;
use App\Models\Dosen;
use App\Models\Tugas;
use App\Models\TugasKelompok;
use Illuminate\Support\Facades\DB;

class DosenController extends Controller
{
    public function dashboard()
    {
        if (!session()->has('user') || session('user')->role!== 'dosen') {
            return redirect('/')->withErrors(['access' => 'Anda tidak memiliki akses ke halaman ini']);
        }

        // Ambil data dosen berdasarkan sesi user
        $dosen = Dosen::where('id_user', session('user')->id_user)->first();

        if (!$dosen) {
            return redirect('/')->withErrors(['access' => 'Dosen tidak ditemukan']);
        }

        // Ambil data kelompok yang dibimbing oleh dosen ini
        $kelompok = Kelompok::where('id_dosen', $dosen->id_dosen)
            ->with(['mahasiswa1', 'mahasiswa2', 'dosen'])
            ->get();

        return view('dosen.dashboard', compact('kelompok'));
    }

    public function showLogbook($nim)
    {
        if (!session()->has('user') || session('user')->role !== 'dosen') {
            return redirect('/')->withErrors(['access' => 'Anda tidak memiliki akses ke halaman ini']);
        }

        // Ambil data dosen berdasarkan sesi user
        $dosen = Dosen::where('id_user', session('user')->id_user)->first();

        if (!$dosen) {
            return redirect('/')->withErrors(['access' => 'Dosen tidak ditemukan']);
        }

        // Ambil data mahasiswa berdasarkan NIM
        $mahasiswa = Kelompok::where('id_dosen', $dosen->id_dosen)
            ->where(function ($query) use ($nim) {
                $query->where('nim1', $nim)->orWhere('nim2', $nim);
            })
            ->with(['mahasiswa1', 'mahasiswa2'])
            ->first();

        if (!$mahasiswa) {
            return redirect()->route('dosen.dashboard')->withErrors(['error' => 'Mahasiswa tidak ditemukan atau tidak terkait dengan dosen ini']);
        }

        // Ambil data logbook mahasiswa
        $logbooks = \App\Models\Logbook::where('nim', $nim)->get();

        return view('dosen.logbook', compact('mahasiswa', 'logbooks'));
    }

    public function storeTugas(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'deadline' => 'required|date',
        ]);

        // Simpan tugas baru ke tabel `tugas`
        $tugas = Tugas::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
        ]);

        // Ambil semua kelompok yang sudah terdaftar
        $kelompokList = Kelompok::all();

        // Sisipkan tugas ke semua kelompok melalui tabel pivot `tugas_kelompok`
        foreach ($kelompokList as $kelompok) {
            DB::table('tugas_kelompok')->insert([
                'id_klp' => $kelompok->id_klp,
                'id_tugas' => $tugas->id_tugas,
                'status' => 'belum mengumpulkan',
                'file' => null,
                'waktu_kumpul' => null,
            ]);
        }

        return redirect()->back()->with('success', 'Tugas berhasil ditambahkan dan ditautkan ke semua kelompok.');
    }

    public function simpanNilai(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'bobot' => 'required|numeric|min:0|max:100',
        ]);

        $tugasKelompok = TugasKelompok::findOrFail($id);

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
        $rataRataNilai = TugasKelompok::where('id_tugas', $tugasKelompok->id_tugas)
            ->avg('nilai');

        // Update capaian maksimal di tabel tugas
        DB::table('tugas')->where('id', $tugasKelompok->id_tugas)->update([
            'capaian_maksimal' => $rataRataNilai,
        ]);

        return redirect()->route('dosen.detail-tugas', $tugasKelompok->id_tugas)
                        ->with('success', 'Nilai berhasil disimpan dan capaian maksimal diperbarui.');
    }
}
