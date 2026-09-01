<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureSingleSession
{
    /**
     * Handle an incoming request.
     *
     * Setiap login berhasil menyimpan token baru di kolom users.current_login_token
     * dan di session. Kalau token session tidak cocok lagi dengan yang di database,
     * berarti akun ini sudah login dari device/browser lain — sesi ini dipaksa keluar.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($request->session()->get('login_token') !== $user->current_login_token) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/')->with('gagal', 'Akun ini sedang login di perangkat lain.');
            }
        }

        return $next($request);
    }
}
