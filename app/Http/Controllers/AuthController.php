<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Koordinator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nim'      => 'required|unique:mahasiswa,nim',
            'username' => 'required|unique:user,username',
            'password' => 'required|min:8',
            'nama'     => 'required',
            'no_telp'  => 'required|numeric',
            'status_mengulang' => 'required|in:mengulang,tidak_mengulang',
            'dosen_sebelum' => [
                'required_if:status_mengulang,mengulang',
                function($attribute, $value, $fail) {
                    if (!\App\Models\Dosen::where('nama_dosen', $value)->exists()) {
                        $fail('Dosen sebelum tidak valid.');
                    }
                }
            ]
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => 'mahasiswa'
        ]);

        Mahasiswa::create([
                'nim' => $request->nim,
                'nama_mhs' => $request->nama,
                'no_telp' => $request->no_telp,
                'status_mengulang' => $request->status_mengulang,
                'dosen_sebelum' => $request->status_mengulang == 'mengulang' ? $request->dosen_sebelum : null,
                'id_user' => $user->id_user
        ]);

        return redirect('/')->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'role'     => 'required|in:mahasiswa,dosen,koordinator'
        ]);

        // Cari pengguna berdasarkan username dan role
        $user = User::where('username', $request->username)
                    ->where('role', $request->role)
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['login' => 'Username, password, atau role salah.'])->withInput();
        }

        // Simpan data ke session
        Auth::login($user);
        session(['user' => $user]);

        // Redirect berdasarkan role
        if ($user->role === 'mahasiswa') {
            return redirect()->route('mahasiswa.dashboard');
        } elseif ($user->role === 'dosen') {
            return redirect()->route('dosen.dashboard');
        } elseif ($user->role === 'koordinator') {
            return redirect()->route('koordinator.dashboard');
        }
    }

    public function logout()
    {
        session()->forget('user');
        return redirect('/');
    }
}
