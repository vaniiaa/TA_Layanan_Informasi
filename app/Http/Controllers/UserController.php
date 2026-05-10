<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
{
    $users = User::with('role')
        ->whereHas('role', function ($q) {
            $q->where('name', '!=', 'admin');
        })
        ->get();

    return view('admin.users.index', compact('users'));
}
   public function create()
{
    $roles = Role::whereIn('name', ['p2m', 'pemberantasan'])->get();

    $users = User::with('role')
        ->whereHas('role', function ($q) {
            $q->where('name', '!=', 'admin');
        })
        ->get();

    return view('admin.tambah_akun', compact('roles', 'users'));
}
public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'role_id' => 'required'
    ]);

    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'role_id' => $request->role_id,
    ];

    if ($request->password) {
        $data['password'] = Hash::make($request->password);
    }

    $user->update($data);

    return back()->with('success', 'User berhasil diupdate');
}
public function destroy($id)
{
    $user = User::findOrFail($id);

    $user->delete();

    return back()->with('deleted', 'User berhasil dihapus');
}

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role_id' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id
        ]);

        return redirect()->route('admin.tambah_akun')
            ->with('success', 'User berhasil ditambahkan');
    }
}
