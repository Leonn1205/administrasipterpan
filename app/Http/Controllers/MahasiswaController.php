<?php

namespace App\Http\Controllers;
use App\Models\Kelompok;
use App\Models\Mahasiswa;
use App\Models\Tugas;
use App\Models\Dosen;
use App\Models\TugasKelompok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('id_user', $user->id_user)->first();

        if (!$mahasiswa) {
            return redirect('/')->withErrors(['akses' => 'Data mahasiswa tidak ditemukan.']);
        }

        $kelompok = Kelompok::where(function ($query) use ($mahasiswa) {
                $query->where('nim1', $mahasiswa->nim)
                    ->orWhere('nim2', $mahasiswa->nim);
            })
            ->first();

        $kelompokCollection = $kelompok ? collect([$kelompok]) : collect();
        $nim1 = $kelompok ? Mahasiswa::where('nim', $kelompok->nim1)->first() : null;
        $nim2 = $kelompok ? Mahasiswa::where('nim', $kelompok->nim2)->first() : null;
        $dosen = $kelompok ? Dosen::find($kelompok->id_dosen) : null;

        $sudahPunyaKelompok = $kelompok !== null;

        return view('mahasiswa.dashboard', compact('mahasiswa', 'kelompokCollection', 'nim1', 'nim2', 'dosen', 'sudahPunyaKelompok'));
    }

    public function storeKelompok(Request $request)
    {
        $request->validate([
            'nim1' => 'required',
            'nama1' => 'required',
            'nim2' => 'required|different:nim1',
            'nama2' => 'required',
        ], [
            'nim2.different' => 'NIM Mahasiswa 1 dan NIM Mahasiswa 2 tidak boleh sama.',
        ]);

        $authUser = auth()->user();
        $loggedInMahasiswa = $authUser ? $authUser->mahasiswa : null;

        if (!$loggedInMahasiswa) {
            return back()->with('error', 'Mahasiswa tidak ditemukan!');
        }

        $mhs1 = Mahasiswa::where('nim', $request->nim1)->first();
        $mhs2 = Mahasiswa::where('nim', $request->nim2)->first();

        if (!$mhs1 || !$mhs2) {
            return back()->with('error', 'Salah satu atau kedua NIM tidak ditemukan di database mahasiswa!')->withInput();
        }

        $sudahAda = Kelompok::where('nim1', $request->nim1)
            ->orWhere('nim2', $request->nim1)
            ->orWhere('nim1', $request->nim2)
            ->orWhere('nim2', $request->nim2)
            ->exists();

        if ($sudahAda) {
            return back()->with('error', 'Salah satu atau kedua NIM sudah terdaftar di kelompok lain!')->withInput();
        }

        $kelompok = Kelompok::create([
            'id_dosen' => null,
            'nim1' => $request->nim1,
            'nim2' => $request->nim2,
        ]);

        $allTugas = Tugas::all();

        foreach ($allTugas as $tugas) {
            DB::table('tugas_kelompok')->insert([
                'id_klp' => $kelompok->id_klp,
                'id_tugas' => $tugas->id_tugas,
                'status' => 'belum mengumpulkan',
                'file' => null,
                'waktu_kumpul' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect('/mahasiswa/dashboard')->with('success', 'Kelompok berhasil dibuat dan tugas berhasil ditautkan!');
    }




    public function getByNim($nim)
    {
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if ($mahasiswa) {
            return response()->json(['nama' => $mahasiswa->nama_mhs]);
        } else {
            return response()->json(['error' => 'Mahasiswa tidak ditemukan'], 404);
        }
    }

    public function tugas()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        $kelompok = Kelompok::where('nim1', $mahasiswa->nim)->orWhere('nim2', $mahasiswa->nim)->first();

        $tugasList = $kelompok
            ? $kelompok->tugas // relasi many-to-many
            : collect(); // kosongkan jika belum punya kelompok

        return view('mahasiswa.tugas', compact('tugasList'));
    }

    public function downloadTugasDosen($id)
    {
        $tugas = Tugas::findOrFail($id);
        $filePath = storage_path('app/public/' . $tugas->file_tugas_dosen);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        $ext = pathinfo($filePath, PATHINFO_EXTENSION);
        $judul = preg_replace('/[^A-Za-z0-9_\-]/', '_', $tugas->judul);
        $downloadName = $judul . '.' . $ext;

        return response()->download($filePath, $downloadName);
    }

    public function uploadTugas(Request $request, $id_tugas)
    {
        $request->validate([
            'file_tugas_mhs' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $mahasiswa = Auth::user()->mahasiswa;

        // Mengambil kelompok berdasarkan accessor (bukan method)
        $kelompok = $mahasiswa->kelompok;

        if (!$kelompok) {
            return redirect()->back()->with('error', 'Anda belum tergabung dalam kelompok.');
        }

        // Proses upload file
        $file = $request->file('file_tugas_mhs');
        $fileName = 'tugas_' . $id_tugas . '_klp_' . $kelompok->id_klp . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('uploads/jawaban', $fileName, 'public');

        // Update pivot table tugas_kelompok
        DB::table('tugas_kelompok')
            ->where('id_klp', $kelompok->id_klp)
            ->where('id_tugas', $id_tugas)
            ->update([
                'file_tugas_mhs' => $filePath,
                'nim_pengumpul' => $mahasiswa->nim,
            ]);

        return redirect()->route('mahasiswa.tugas')->with('success', 'Tugas berhasil diupload.');
    }


    public function prosesUploadTugas(Request $request, $id)
    {
        $request->validate([
            'file_tugas' => 'required|mimes:pdf,docx,zip|max:2048',
        ]);

        $user = session('user');
        if (!$user) {
            dd('User tidak login / session kosong');
        }

        $mahasiswa = Mahasiswa::where('id_user', $user->id_user)->first();
        if (!$mahasiswa) {
            dd('Mahasiswa tidak ditemukan');
        }

        $kelompok = Kelompok::where('nim1', $mahasiswa->nim)
                            ->orWhere('nim2', $mahasiswa->nim)
                            ->first();
        if (!$kelompok) {
            dd('Kelompok tidak ditemukan untuk nim ' . $mahasiswa->nim);
        }

        $tugas = Tugas::find($id);
        if (!$tugas) {
            dd('Tugas tidak ditemukan untuk id ' . $id);
        }

        dd($request->all(), $mahasiswa, $kelompok, $tugas);
    }

    public function nilai()
    {
        $tugasKelompok = TugasKelompok::with('tugas')->where('nim_pengumpul', Auth::user()->mahasiswa->nim)->get();
        $capaianMaksimal = TugasKelompok::avg('nilai');
        $nilaiHuruf = $this->calculateHuruf($capaianMaksimal);

        return view('mahasiswa.nilai', compact('tugasKelompok', 'capaianMaksimal', 'nilaiHuruf'));
    }

    private function calculateHuruf($nilai)
    {
        if ($nilai >= 85) return 'A';
        if ($nilai >= 70) return 'B';
        if ($nilai >= 60) return 'C';
        if ($nilai >= 50) return 'D';
        return 'E';
    }





}
