<?php

namespace App\Http\Controllers;

use App\Models\MateriEdukasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriEdukasiController extends Controller
{
   //menampilkan halaman materi edukasi admin
   public function index()
{
    // Ambil data paling baru dengan pagination
    $materi = MateriEdukasi::with('user')
    ->orderBy('id', 'DESC')
    ->paginate(10);

    return view('admin.p2m.materi_edukasi', compact('materi'));
}
    //mnampilkan halaman materi edukasi bagian user
    public function userIndex()
{
    $materi = MateriEdukasi::latest()->paginate(12);
    return view('user.p2m.materi_edukasi', compact('materi'));
}

    //menampilkan halaman materi untuk user p2m
    public function indexMateri()
    {
        // Ambil data materi terbaru
        $materi = MateriEdukasi::latest()->paginate(10);

        // Tampilkan ke halaman P2M
        return view('p2m.materi_edukasi', compact('materi'));
    }

    //tambah data
    public function store(Request $request)
    {   
        //validasi request
        $request->validate([
        'jenis' => 'required',

        // ARTIKEL
        'judul_artikel' => 'required_if:jenis,artikel',
        'deskripsi_artikel' => 'required_if:jenis,artikel',
        'gambar_artikel' => 'required_if:jenis,artikel|image|mimes:jpg,jpeg,png|max:2048',

        // INFOGRAFIS
        'judul_infografis' => 'required_if:jenis,infografis',
        'deskripsi_infografis' => 'required_if:jenis,infografis',
        'gambar_infografis' => 'required_if:jenis,infografis|image|mimes:jpg,jpeg,png|max:2048',

        // MODUL
        'judul_modul' => 'required_if:jenis,modul',
        'deskripsi_modul' => 'required_if:jenis,modul',
        'file_modul' => 'required_if:jenis,modul|mimes:pdf|max:2048',

        // VIDEO
        'judul_video' => 'required_if:jenis,video',
        'deskripsi_video' => 'required_if:jenis,video',
        'video_file' => 'required_if:jenis,video|mimes:mp4|max:10240',
    ]);

         //ambil jenis materi
        $jenis = $request->jenis;
        $data = [
                'jenis' => $jenis,
                'user_id' => Auth::id() 
                ];    

        // ==================== ARTIKEL ====================
        if ($jenis === 'artikel') {
            $data['judul'] = $request->judul_artikel;
            $data['deskripsi'] = $request->deskripsi_artikel;

            if ($request->hasFile('gambar_artikel')) {
                $data['gambar'] = $request->file('gambar_artikel')->store('materi/gambar', 'public');
            }
        }

        // ==================== INFOGRAFIS ====================
        if ($jenis === 'infografis') {
            $data['judul'] = $request->judul_infografis;
            $data['deskripsi'] = $request->deskripsi_infografis;

            if ($request->hasFile('gambar_infografis')) {
                $data['gambar'] = $request->file('gambar_infografis')->store('materi/gambar', 'public');
            }
        }

        // ==================== MODUL ====================
        if ($jenis === 'modul') {
            $data['judul'] = $request->judul_modul;
            $data['deskripsi'] = $request->deskripsi_modul;

            if ($request->hasFile('file_modul')) {
                $data['file_modul'] = $request->file('file_modul')->store('materi/modul', 'public');
            }
        }

        // ==================== VIDEO ====================
        if ($jenis === 'video') {
            $data['judul'] = $request->judul_video;
            $data['deskripsi'] = $request->deskripsi_video;

            if ($request->hasFile('video_file')) {
                $data['video_file'] = $request->file('video_file')->store('materi/video', 'public');
            }
        }

        MateriEdukasi::create($data);
        return redirect()->back()->with('success', 'Berhasil menambahkan materi.');
    }

    //edit data materi
    public function update(Request $request, $id)
    {
        $materi = MateriEdukasi::findOrFail($id);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ];

        // ================= ARTIKEL =================
        if ($materi->jenis === 'artikel' && $request->hasFile('gambar_artikel')) {
            if ($materi->gambar && file_exists(public_path('storage/'.$materi->gambar))) {
                unlink(public_path('storage/'.$materi->gambar));
            }
            $data['gambar'] = $request->file('gambar_artikel')->store('materi/gambar', 'public');
        }

        // ================= INFOGRAFIS =================
        if ($materi->jenis === 'infografis' && $request->hasFile('gambar_infografis')) {
            if ($materi->gambar && file_exists(public_path('storage/'.$materi->gambar))) {
                unlink(public_path('storage/'.$materi->gambar));
            }
            $data['gambar'] = $request->file('gambar_infografis')->store('materi/gambar', 'public');
        }

        // ================= MODUL =================
        if ($materi->jenis === 'modul' && $request->hasFile('file_modul')) {
            if ($materi->file_modul && file_exists(public_path('storage/'.$materi->file_modul))) {
                unlink(public_path('storage/'.$materi->file_modul));
            }
            $data['file_modul'] = $request->file('file_modul')->store('materi/modul', 'public');
        }

        // ================= VIDEO =================
        if ($materi->jenis === 'video') {

            if ($request->hasFile('video_file')) {
                if ($materi->video_file && file_exists(public_path('storage/'.$materi->video_file))) {
                    unlink(public_path('storage/'.$materi->video_file));
                }
                $data['video_file'] = $request->file('video_file')->store('materi/video', 'public');
            }
        }

        $materi->update($data);

    return redirect()->back()->with('success', 'Materi berhasil diperbarui.');
    }

    //hapus data
    public function destroy($id)
    {
        $materi = MateriEdukasi::findOrFail($id);

        if ($materi->gambar && file_exists(public_path('storage/'.$materi->gambar))) {
            unlink(public_path('storage/'.$materi->gambar));
        }

        if ($materi->file_modul && file_exists(public_path('storage/'.$materi->file_modul))) {
            unlink(public_path('storage/'.$materi->file_modul));
        }

        if ($materi->video_file && file_exists(public_path('storage/'.$materi->video_file))) {
            unlink(public_path('storage/'.$materi->video_file));
        }

        $materi->delete();
        return redirect()->back()->with('success', 'Materi berhasil dihapus.');
    }

    //user detail materi edukasi
    public function userDetail($id)
{
    $materi = MateriEdukasi::with('user')->findOrFail($id);
    return view('user.p2m.detail_materi_edukasi', compact('materi'));
}

}
