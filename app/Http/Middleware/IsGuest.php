<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // menentukan halaman yang hanya boleh diakses sebelum login
        if (Auth::check()) {
            // kalau uda login, gabole akses halaman ini, 
            // jadi arahkan kembali ke home
            return redirect()->route('home')->with('error', 'Halaman hanya boleh diakses sebelum login.');
        }else {
            //jika belum login, maka boleh akses halaman ini
            return $next($request);
        }
    }
}
