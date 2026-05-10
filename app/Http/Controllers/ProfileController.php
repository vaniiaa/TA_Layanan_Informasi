<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //menampilkan halaman profile
    public function index()
{
    $user = Auth::user();

    if (!$user) {
        abort(403, 'Unauthorized');
    }

    // ADMIN
    if ($user->role_id == 1) {
        return view('admin.profile', compact('user'));
    }

    // P2M
    if ($user->role_id == 2) {
        return view('p2m.profile', compact('user'));
    }

    // PEMBERANTASAN
    if ($user->role_id == 3) {
        return view('pemberantasan.profile', compact('user'));
    }

    abort(403, 'Role tidak diizinkan');
}
    //update data profile user
    public function update(Request $request)
    {   
        //ambil user yg sedang login
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }
        //validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|min:6|confirmed'
        ]);
        //update data user
        $user->name = $request->name;
        $user->email = $request->email;
        // Jika password diisi, maka akan di-hash dan diupdate
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        //simpan perubahan ke db
        $user->save();
        //redirect ke halaman sebelumnya, dgn pesan sukses
        return back()->with('success', 'Profil berhasil diperbarui');
    }
}