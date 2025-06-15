<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function index()
    {
        return view('login');
    }

    function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'role' => 'required',
        ],[
            'username.required' => 'Username tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'role.required' => 'Role tidak boleh kosong',
        ]);

        $infologin = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($infologin)) {
        $user = Auth::user();
        if ($user->role === 'koordinator') {
            return redirect('/koordinator');
        } elseif ($user->role === 'dosen') {
            return redirect('/dosen');
        } elseif ($user->role === 'mahasiswa') {
            return redirect('/mahasiswa');
        } else {
            Auth::logout();
            return redirect()->back()->withErrors(['login' => 'Role tidak dikenali'])->withInput();
        }
            }else{
                return redirect()->back()->withErrors(['login' => 'Username dan password yang dimasukkan tidak sesuai'])->withInput();
            }
    }
}
