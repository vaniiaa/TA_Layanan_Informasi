<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataSekolah;
use App\Models\User;

class DataSekolahController extends Controller
{
    //menampilkan seluruh datake halaman admin
    public function index()
{
    $data = DataSekolah::with('user.role')
        ->latest()
        ->paginate(10);

    return view('admin.p2m.data_sekolah', compact('data'));
}
    
    //USER P2M
    //menampilkan halaman data sekolah untuk user p2m
    public function p2mIndex()
{
    $data = DataSekolah::with('user.role')
        ->latest()
        ->paginate(10);

    return view('p2m.data_sekolah', compact('data'));
}

    //method untuk menambahkan data sekolah
    public function store(Request $request)
    {
        //validasi input dari form
        $request->validate([
    'npsn' => 'required|unique:data_sekolahs,npsn',
    'nama_sekolah' => 'required|string|max:255',
    'alamat' => 'required|string',
    'status_sekolah' => 'required|string',
    'bentuk_pendidikan' => 'required|string',
]);

        //simpan data ke db (only 'nama_sekolah')
       DataSekolah::create([
    'npsn' => $request->npsn,
    'nama_sekolah' => $request->nama_sekolah,
    'alamat' => $request->alamat,
    'status_sekolah' => $request->status_sekolah,
    'bentuk_pendidikan' => $request->bentuk_pendidikan,
    'user_id' => auth()->id(), 
]);

        //redirect kembali ke halaman sebelumnya dan alert pesan sukses
        return redirect()->back()->with('success', 'Sekolah berhasil ditambahkan.');
    }

    //Method untuk update/edit data sekolah
    public function update(Request $request, $id)
    {   
        //validasi input
        $request->validate([
    'npsn' => 'required|unique:data_sekolahs,npsn,' . $id,
    'nama_sekolah' => 'required|string|max:255',
    'alamat' => 'required|string',
    'status_sekolah' => 'required|string',
    'bentuk_pendidikan' => 'required|string',
]);

        //cari data berdasarkan ID
        $sekolah = DataSekolah::findOrFail($id);

$sekolah->update($request->only([
    'npsn',
    'nama_sekolah',
    'alamat',
    'status_sekolah',
    'bentuk_pendidikan'
]));
        //kembali ke halaman sebelumnya dan alert pesan sukses
        return redirect()->back()->with('success', 'Sekolah berhasil diubah.');
    }

    //Method untuk menghapus data sekolah
    public function destroy($id)
    {
        //cari data berdasarkan ID
        $sekolah = DataSekolah::findOrFail($id);
        //hapus datadari database
        $sekolah->delete();
        //redirect kembali dan alert pesan sukses
        return redirect()->back()->with('success', 'Sekolah berhasil dihapus.');
    }
}