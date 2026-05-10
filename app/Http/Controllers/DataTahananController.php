<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataTahanan;

class DataTahananController extends Controller
{
    // ADMIN
    public function index()
    {
        $tahanan = DataTahanan::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.pemberantasan.data_tahanan', compact('tahanan'));
    }

    // USER PEMBERANTASAN
    public function pemberantasanIndex()
    {
        $tahanan = DataTahanan::with('user')
            ->latest()
            ->paginate(10);

        return view('pemberantasan.data_tahanan', compact('tahanan'));
    }

    // TAMBAH DATA
    public function store(Request $request)
    {
        $request->validate([
            'nomor_tahanan' => 'required|string|unique:data_tahanan,nomor_tahanan',
            'nama_tahanan' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'umur' => 'required|integer',
            'jenis_kelamin' => 'required|string',
            'pendidikan' => 'required|string',
            'pekerjaan' => 'required|string',
            'tinggi_badan' => 'required|integer',
            'berat_badan' => 'required|integer',
            'warna_kulit' => 'required|string',
            'warna_mata' => 'required|string',
            'bentuk_muka' => 'required|string',
            'suku' => 'required|string',
            'dimulai_penahanan' => 'required|date',
            'pasal_dilanggar' => 'required|string',
            'warga_negara' => 'required|string',
        ]);

        DataTahanan::create([
            'nomor_tahanan' => $request->nomor_tahanan,
            'nama_tahanan' => $request->nama_tahanan,
            'tanggal_lahir' => $request->tanggal_lahir,
            'umur' => $request->umur,
            'jenis_kelamin' => $request->jenis_kelamin,
            'pendidikan' => $request->pendidikan,
            'pekerjaan' => $request->pekerjaan,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'warna_kulit' => $request->warna_kulit,
            'warna_mata' => $request->warna_mata,
            'bentuk_muka' => $request->bentuk_muka,
            'suku' => $request->suku,
            'dimulai_penahanan' => $request->dimulai_penahanan,
            'pasal_dilanggar' => $request->pasal_dilanggar,
            'warga_negara' => $request->warga_negara,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Data tahanan berhasil ditambahkan');
    }

    // EDIT DATA
    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_tahanan' => 'required|string|unique:data_tahanan,nomor_tahanan,' . $id,
            'nama_tahanan' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'umur' => 'required|integer',
            'jenis_kelamin' => 'required|string',
            'pendidikan' => 'required|string',
            'pekerjaan' => 'required|string',
            'tinggi_badan' => 'required|integer',
            'berat_badan' => 'required|integer',
            'warna_kulit' => 'required|string',
            'warna_mata' => 'required|string',
            'bentuk_muka' => 'required|string',
            'suku' => 'required|string',
            'dimulai_penahanan' => 'required|date',
            'pasal_dilanggar' => 'required|string',
            'warga_negara' => 'required|string',
        ]);

        $tahanan = DataTahanan::findOrFail($id);

        $tahanan->update([
            'nomor_tahanan' => $request->nomor_tahanan,
            'nama_tahanan' => $request->nama_tahanan,
            'tanggal_lahir' => $request->tanggal_lahir,
            'umur' => $request->umur,
            'jenis_kelamin' => $request->jenis_kelamin,
            'pendidikan' => $request->pendidikan,
            'pekerjaan' => $request->pekerjaan,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'warna_kulit' => $request->warna_kulit,
            'warna_mata' => $request->warna_mata,
            'bentuk_muka' => $request->bentuk_muka,
            'suku' => $request->suku,
            'dimulai_penahanan' => $request->dimulai_penahanan,
            'pasal_dilanggar' => $request->pasal_dilanggar,
            'warga_negara' => $request->warga_negara,
        ]);

        return back()->with('success', 'Data tahanan berhasil diubah');
    }

    // HAPUS DATA
    public function destroy($id)
    {
        $tahanan = DataTahanan::findOrFail($id);
        $tahanan->delete();

        return back()->with('deleted', 'Data tahanan berhasil dihapus');
    }
}