<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //menampilkan halaman formlogin
    public function showLoginForm()
    {
        return view('auth.login');
    }

    //proses login user
    public function login(Request $request)
    {
        //validasi input email dan password
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        //coba login menggunakan data yang terdaftar
        if (!Auth::attempt($credentials)) {
            //jika gagal login, kembali ke halaman sebelumnya dengan pesan error
            return back()->with('error', 'Email atau password salah');
        }

        //regenerasi session untuk keamanan (mencegah session hijacking)
        $request->session()->regenerate();

        //redirect berdasarkan role user yg login
   return match (auth()->user()->role->name) {
    'admin' => redirect()->route('admin.dashboard'),
    'pemberantasan' => redirect()->route('pemberantasan.dashboard'),
    'p2m' => redirect()->route('p2m.dashboard'),
    default => $this->logoutInvalidRole($request),
};
    }

    //logout otomatis jika role tidak valid
    private function logoutInvalidRole(Request $request)
    {
        //logout user
        Auth::logout();
        //hapus session
        $request->session()->invalidate();
        //kembali ke halaman login dengan pesan error
        return back()->with('error', 'Role tidak valid');
    }

    //logout manual ketika user klik tombol logout
    public function logout(Request $request)
    {
        //logout user
        Auth::logout();
        //hapus semua session
        $request->session()->invalidate();
        //regenerasi token CSRF untuk keamanan
        $request->session()->regenerateToken();
        //redirect kembali kehalaman login
        return redirect()->route('login');
    }
}
