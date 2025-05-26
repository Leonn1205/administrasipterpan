<?php

namespace App\Http\Controllers;
use App\Models\Kelompok;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        //dd(session('user'));
        $kelompok = Kelompok::where(function($query) {
        $query->where('nim1', session('user')->nim)
              ->orWhere('nim2', session('user')->nim);
        })->with(['mahasiswa1', 'mahasiswa2', 'dosen'])->get();
        //dd($kelompok);
        return view('mahasiswa.dashboard', compact('kelompok'));
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

        $mhs1 = Mahasiswa::where('nim', $request->nim1)->first();
        $mhs2 = Mahasiswa::where('nim', $request->nim2)->first();

        if (!$mhs1 || !$mhs2) {
            return back()->with('error', 'Salah satu atau kedua NIM tidak ditemukan di database mahasiswa!')->withInput();
        }

        Kelompok::create([
            'id_dosen' => null,
            'nim1' => $request->nim1,
            'nim2' => $request->nim2,
        ]);

        return redirect('/mahasiswa/dashboard')->with('success', 'Kelompok berhasil dibuat!');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
}
