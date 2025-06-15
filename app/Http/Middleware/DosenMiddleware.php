<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DosenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'dosen') {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
