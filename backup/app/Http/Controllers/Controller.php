<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function login()
    {
        return view('home.login');
    }

    public function auth(Request $request)
    {
        $validate = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        if (Auth::attempt($validate)) {
            if (Auth::user()->level == 'marketing') {

                $request->session()->regenerate();
                return redirect()->intended('/marketing');
            }
            if (Auth::user()->level == 'staf') {
                $request->session()->regenerate();
                return redirect()->intended('/presensi');
            } 
            if (Auth::user()->level == 'admin') {
                $request->session()->regenerate();
                return redirect()->intended('/admin');
            } 
            if (Auth::user()->level == 'master') {
                $request->session()->regenerate();
                return redirect()->intended('/admin');
            } 
        }

        return back()->with('gagal', 'Username / Password Salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('logout', 'Username / Password Salah');
    }

    
}
