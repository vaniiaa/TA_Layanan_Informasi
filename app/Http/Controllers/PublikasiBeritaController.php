<?php

namespace App\Http\Controllers;

use App\Models\PublikasiBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  
use Illuminate\Support\Facades\Storage;

class PublikasiBeritaController extends Controller
{
    //menampilkan halaman publikasi admin
    public function index()
    {
        // Ambil semua data publikasi dari database
        // diurutkan dari terbaru ke lama + pagination 10 data
        $publikasi = PublikasiBerita::orderBy('id','DESC')->paginate(10);
        //kirim ke view admin
        return view('admin.pemberantasan.publikasi_berita', compact('publikasi'));
    }

    //menampilkan halaman publikasi untuk user pemberantasan
    public function pemberantasanIndex()
    {
        $publikasi = PublikasiBerita::orderBy('id','DESC')->paginate(10);
        //kirim ke view pemberantasan
        return view('pemberantasan.publikasi_berita', compact('publikasi'));
    }

    // menampilkan halaman publikasi untuk user
    public function userIndex()
    {
        $publikasi = PublikasiBerita::latest()->get();
        return view('user.pemberantasan.publikasi_berita', compact('publikasi'));
    }

    //simpan data
    public function store(Request $request)
    {   
        //validasi input berdasar jenis publikasi
        $request->validate([
        'jenis' => 'required',

        // ================= BERITA =================
        'judul_berita' => 'required_if:jenis,berita',
        'deskripsi_berita' => 'required_if:jenis,berita',
        'gambar_berita' => 'required_if:jenis,berita|image|mimes:jpg,jpeg,png|max:2048',

        // ================= INFOGRAFIS =================
        'judul_infografis' => 'required_if:jenis,infografis',
        'deskripsi_infografis' => 'required_if:jenis,infografis',
        'gambar_infografis' => 'required_if:jenis,infografis|image|mimes:jpg,jpeg,png|max:2048',
    ]); 

        //ambil jenis publikasi
        $jenis = $request->jenis;
        $data = [
        'jenis' => $jenis,
        'user_id' => Auth::id() //menyimpan authors atau siapa yg menginput
    ];
         // ================= BERITA =================
        if ($jenis === 'berita') {
            $data['judul'] = $request->judul_berita;
            $data['deskripsi'] = $request->deskripsi_berita;

            if ($request->hasFile('gambar_berita')) {
                $data['gambar'] = $request->file('gambar_berita')
                ->store('publikasi_berita/berita','public');
            }
        }

        // ================= INFOGRAFIS =================
        if ($jenis === 'infografis') {
            $data['judul'] = $request->judul_infografis;
            $data['deskripsi'] = $request->deskripsi_infografis;

            if ($request->hasFile('gambar_infografis')) {
                $data['gambar'] = $request->file('gambar_infografis')
                ->store('publikasi_berita/infografis','public');
            }
        }
        //simpan ke db
        PublikasiBerita::create($data);
        //redirect kembali dgn pesan sukses
        return redirect()->back()->with('success','Berhasil menambahkan publikasi berita.');
    }

    //update data
    public function update(Request $request, $id)
    {   
        $publikasi = PublikasiBerita::findOrFail($id);

        // VALIDASI
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ];

        // JIKA ADA GAMBAR BARU
        if ($request->hasFile('gambar')) {

            // hapus gambar lama
            if ($publikasi->gambar && Storage::disk('public')->exists($publikasi->gambar)) {
                Storage::disk('public')->delete($publikasi->gambar);
            }

            // simpan gambar baru sesuai jenis
            if ($publikasi->jenis === 'berita') {
                $path = $request->file('gambar')->store('publikasi_berita/berita', 'public');
            } else {
                $path = $request->file('gambar')->store('publikasi_berita/infografis', 'public');
            }

            $data['gambar'] = $path;
        }

        $publikasi->update($data);

        return redirect()->back()->with('success','Publikasi berita berhasil diperbarui.');
    }

    //hapus data
    public function destroy($id)
    {
        $publikasi = PublikasiBerita::findOrFail($id);

        if($publikasi->gambar && file_exists(public_path('storage/'.$publikasi->gambar))){
            unlink(public_path('storage/'.$publikasi->gambar));
        }

        $publikasi->delete();

        return redirect()->back()->with('success','Publikasi berhasil dihapus.');
    }

    //menapilkan detail dari publikasi
    public function userDetail($id)
{
    $publikasi = PublikasiBerita::with('user')->findOrFail($id);
    return view('user.pemberantasan.detail_publikasi_berita', compact('publikasi'));
}
}