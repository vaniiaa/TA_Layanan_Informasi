<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\SosialisasiNarkoba;
use App\Exports\SosialisasiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class SosialisasiNarkobaController extends Controller
{
    
   public function store(Request $request)
{
    //validasi input form
    $validated = $request->validate([
        'nama_lengkap' => 'required|string|max:255',
        'instansi' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
        'no_hp' => 'required|string|max:50',
        'nama_kegiatan' => 'required|string',
        'tanggal_kegiatan' => 'required|date',
        'waktu_kegiatan' => 'required',
        'lokasi' => 'required|string|max:255',
        'peserta' => 'required|string|max:100',
        'jumlah_peserta' => 'required|integer|min:1',
        'surat_permohonan' => 'required|file|mimes:pdf,doc,docx|max:2048',
        'konfirmasi' => 'required|in:Saya memahami bahwa data yang diisikan dalam formulir ini benar dan bertanggung jawab atas hal tersebut',
    ], [
        'surat_permohonan.required' => 'File surat permohonan wajib diunggah.',
        'surat_permohonan.mimes' => 'File harus berformat PDF, DOC, atau DOCX.',
        'surat_permohonan.max' => 'Ukuran file maksimal 2MB.',
    ]);

    try {
        //upload file ke storage
        $file = $request->file('surat_permohonan');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('surat_permohonan', $fileName, 'public');

        //simpan data ke db
        $data = SosialisasiNarkoba::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'instansi' => $validated['instansi'],
            'alamat' => $validated['alamat'],
            'no_hp' => $validated['no_hp'],
            'nama_kegiatan' => $validated['nama_kegiatan'],
            'tanggal_kegiatan' => $validated['tanggal_kegiatan'],
            'waktu_kegiatan' => $validated['waktu_kegiatan'],
            'lokasi' => $validated['lokasi'],
            'peserta' => $validated['peserta'],
            'jumlah_peserta' => $validated['jumlah_peserta'],
            'surat_permohonan' => $fileName,
            'konfirmasi' => $validated['konfirmasi'],
        ]);

        //simpan session untuk halaman konfirmasi
        session([
            'nama_lengkap' => $data->nama_lengkap,
            'tanggal_pendaftaran' => now()->format('d-m-Y'),
        ]);

        //arahkan kehalaman konfirmasi
        return redirect()->route('sosialisasi.konfirmasi')->with('success', 'Permohonan berhasil dikirim!');
    
    } catch (\Exception $e) {
        //ERROR HANDLING
        return back()->withErrors(['error' => 'Gagal menyimpan data. Silakan coba lagi.'])->withInput();
    }
}

//download bukti
public function downloadBukti()
{
    $nama = session('nama_lengkap', 'Tidak diketahui');
    $tanggal = session('tanggal_pendaftaran', now()->format('d-m-Y'));

    $data = [
        'nama' => $nama,
        'tanggal' => $tanggal,
    ];

    // generate tampilan dari view bukti_pdf.blade.php
    $pdf = Pdf::loadView('user.p2m.bukti_pdf', $data)->setPaper('A5', 'portrait');

    return $pdf->download('Bukti_Pendaftaran_Sosialisasi_Narkoba.pdf');
}

// menampilkan data sosialisasi di halaman admin
  public function index(Request $request)
{
    $query = SosialisasiNarkoba::query();

    if ($request->filled('bulan')) {
        $query->whereMonth('created_at', $request->bulan);
    }

    if ($request->filled('tahun')) {
        $query->whereYear('created_at', $request->tahun);
    }
    //search data
    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
              ->orWhere('instansi', 'like', '%' . $request->search . '%');
        });
    }

    // Gunakan paginate agar firstItem() bisa dipanggil
    $data = $query->orderBy('created_at', 'desc')->paginate(10);

    return view('admin.p2m.sosialisasi', compact('data'));
}
  //view surat
  public function viewSurat($id)
{
    $data = SosialisasiNarkoba::findOrFail($id);

    $path = public_path('storage/surat_permohonan/' . $data->surat_permohonan);

    if (!file_exists($path)) {
        abort(404, 'File tidak ditemukan.');
    }

    return response()->file($path);
}
//download surat 
public function downloadSurat($id)
{
    $item = SosialisasiNarkoba::findOrFail($id);

    $filePath = public_path('storage/surat_permohonan/' . $item->surat_permohonan);

    if (!file_exists($filePath)) {
        abort(404, 'File tidak ditemukan.');
    }

    return response()->download($filePath, $item->surat_permohonan);
}

//export excel
public function exportExcel(Request $request)
{
    $bulan = $request->bulan;
    $tahun = $request->tahun;

    return Excel::download(
        new SosialisasiExport($bulan, $tahun),
        'laporan_permohonan_sosialisasi.xlsx'
    );
}

//menampilkan halaman sosialisasi utk user p2m
public function indexP2M(Request $request)
    {
        $query = SosialisasiNarkoba::query();

        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        // Filter berdasarkan tahun
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        // Ambil data terbaru dengan paginate
        $data = $query->latest()->paginate(10);

        return view('p2m.sosialisasi', compact('data'));
    }

}
   
    


    
