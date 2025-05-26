<?php
namespace App\Http\Middleware;

use Closure;

class AuthSession
{
    public function handle($request, \Closure $next)
    {
        if (!session('user')) {
            return redirect('/')->withErrors(['login' => 'Silakan login terlebih dahulu.']);
        }
        return $next($request);
    }
}
