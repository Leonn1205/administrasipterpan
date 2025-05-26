<?php

namespace App\Http\Middleware;

use Closure;

class MahasiswaMiddleware
{
    public function handle($request, \Closure $next)
    {
        // Cek apakah user login sebagai mahasiswa
        if (session('user') && session('user')->role == 'mahasiswa') {
            return $next($request);
        }
        // Jika bukan mahasiswa, redirect ke login
        return redirect('/')->withErrors(['login' => 'Akses hanya untuk mahasiswa!']);
    }
}
