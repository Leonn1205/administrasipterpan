<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logbook;
use App\Models\Dosen;
use App\Models\Kelompok;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;

class LogbookController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        $dosen = Auth::user();
        if (!$mahasiswa) {
            return redirect()->route('login')->withErrors(['error' => 'Data mahasiswa tidak ditemukan.']);
        }

        // Ambil logbook berdasarkan nim mahasiswa yang sedang login
        $logbooks = Logbook::where('nim', $mahasiswa->nim)->get();

        return view('mahasiswa.logbook', compact('logbooks'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'tanggal' => 'required|date',
        'uraian_kegiatan' => 'required',
        'waktu_mulai' => 'required',
        'waktu_selesai' => 'required',
        'yang_terlibat' => 'required',
        ]);

        // Ambil nim dari relasi mahasiswa
        $mahasiswa = Auth::user()->mahasiswa;

        if (!$mahasiswa || !$mahasiswa->nim) {
            return redirect()->back()->withErrors(['nim' => 'NIM tidak ditemukan untuk pengguna ini.']);
        }

        Logbook::create([
            'nim' => $mahasiswa->nim,
            'tanggal' => $request->tanggal,
            'uraian_kegiatan' => $request->uraian_kegiatan,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'yang_terlibat' => $request->yang_terlibat,
        ]);

        return redirect()->route('logbook.index')->with('success', 'Logbook berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'uraian_kegiatan' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'yang_terlibat' => 'required',
        ]);

        $mahasiswa = Auth::user()->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->route('login')->withErrors(['error' => 'Data mahasiswa tidak ditemukan.']);
        }

        $logbook = Logbook::where('id_logbook', $id)
            ->where('nim', $mahasiswa->nim)
            ->firstOrFail();

        $logbook->update($request->only([
            'tanggal', 'uraian_kegiatan', 'waktu_mulai', 'waktu_selesai', 'yang_terlibat'
        ]));

        return redirect()->route('logbook.index')->with('success', 'Logbook berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->route('login')->withErrors(['error' => 'Data mahasiswa tidak ditemukan.']);
        }

        $logbook = Logbook::where('id_logbook', $id)
            ->where('nim', $mahasiswa->nim)
            ->firstOrFail();

        $logbook->delete();

        return redirect()->route('logbook.index')->with('success', 'Logbook berhasil dihapus.');
    }


    public function showLogbook()
    {
        $user = Auth::user();

        $dosen = Dosen::where('id_user', $user->id_user)->first();

        if (!$dosen) {
            return redirect()->back()->with('error', 'Dosen tidak ditemukan');
        }

        // Ambil semua kelompok yang diampu dosen ini
        $kelompok = Kelompok::where('id_dosen', $dosen->id_dosen)->get();

        // Ambil semua NIM dari kelompok
        $nims = [];
        foreach ($kelompok as $k) {
            if ($k->nim1) $nims[] = $k->nim1;
            if ($k->nim2) $nims[] = $k->nim2;
        }

        // Ambil semua logbook berdasarkan NIM
        $logbook = Logbook::whereIn('nim', $nims)->with('mahasiswa')->get();

        return view('dosen.logbook', compact('logbook'));
    }

    public function detailLogbook($nim)
    {
        $mahasiswa = Mahasiswa::with('user')->where('nim', $nim)->firstOrFail();
        $logbook = Logbook::where('nim', $nim)->get();

        return view('dosen.logbook_detail', compact('mahasiswa', 'logbook'));
    }

}
