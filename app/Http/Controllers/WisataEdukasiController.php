<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\WisataExport; 
use App\Models\WisataEdukasi;
use App\Models\DataSekolah;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;


class WisataEdukasiController extends Controller
{
    // Form user
    public function create()
    {
        $sekolah = DataSekolah::all();
        return view('user.p2m.wisata_edukasi', compact('sekolah'));
    }

    // Simpan data
    public function store(Request $request)
    {
        //validasi input
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            
            'data_sekolah_id' => 'required|exists:data_sekolahs,id',
           
            'no_telp' => 'required|string|max:20',
            'tanggal_kegiatan' => 'required|date',
            'waktu_kegiatan' => 'required',
            'jumlah_peserta' => 'required|integer|min:1|max:30',
            'surat_permohonan' => 'required|file|mimes:pdf,doc,docx|max:2048',
            ],[
            'surat_permohonan.required' => 'File surat permohonan wajib diunggah.',
            'surat_permohonan.mimes' => 'File harus berformat PDF, DOC, atau DOCX.',
            'surat_permohonan.max' => 'Ukuran file maksimal 2MB.',
        ]);

        //upload file
        $file = $request->file('surat_permohonan');
$namaFile = time() . '_' . $file->getClientOriginalName();

$path = $file->storeAs('permohonan_wisata', $namaFile, 'public');
        //simpan ke db
        $wisata = WisataEdukasi::create([
            'nama_lengkap' => $request->nama_lengkap,
            
            'data_sekolah_id' => $request->data_sekolah_id,
           
            'no_telp' => $request->no_telp,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'waktu_kegiatan' => $request->waktu_kegiatan,
            'jumlah_peserta' => $request->jumlah_peserta,
            'surat_permohonan' => $path,
        ]);
        //simpan session utk bukti pendaftaran
        session([
            'nama_lengkap' => $wisata->nama_lengkap,
            'tanggal_pendaftaran' => now()->format('d-m-Y'),
        ]);

        return redirect()->route('wisata.konfirmasi');
    }

    // Konfirmasi
    public function konfirmasi()
    {
        return view('user.p2m.konfirmasi_wisata');
    }

    // Download bukti PDF
    public function downloadBukti()
    {
        $nama = session('nama_lengkap', 'Tidak diketahui');
        $tanggal = session('tanggal_pendaftaran', now()->format('d-m-Y'));

        $pdf = Pdf::loadView('user.p2m.bukti_pdf_wisata', [
            'nama' => $nama,
            'tanggal' => $tanggal,
        ])->setPaper('A5', 'portrait');

        return $pdf->download('Bukti_Pendaftaran_Wisata_Edukasi.pdf');
    }

    // Admin index
   public function index(Request $request)
{
    $query = WisataEdukasi::with('sekolah');

    if ($request->filled('bulan')) {
        $query->whereMonth('tanggal_kegiatan', $request->bulan);
    }

    if ($request->filled('tahun')) {
        $query->whereYear('tanggal_kegiatan', $request->tahun);
    }

    $wisata = $query->latest()->paginate(10);

    return view('admin.p2m.kunjungan_wisata', compact('wisata'));
}

    // Download surat
    public function downloadSurat($id)
    {
        $data = WisataEdukasi::findOrFail($id);
        $path = storage_path('app/public/' . $data->surat_permohonan);

        if (!file_exists($path)) abort(404, 'File tidak ditemukan.');

        return response()->download($path, basename($path));
    }

    //halaman wisata edukasi utk user p2m
    public function indexWisata(Request $request)
    {
        $query = WisataEdukasi::query();

        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        // Filter berdasarkan tahun
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        // Ambil data terbaru dengan paginate
        $wisata = $query->latest()->paginate(10);

        return view('p2m.kunjungan_wisata', compact('wisata'));
    }
    
    //view surat
    public function viewSurat($id)
{
    $data = WisataEdukasi::findOrFail($id);
    $path = storage_path('app/public/' . $data->surat_permohonan);

    if (!file_exists($path)) {
        abort(404, 'File tidak ditemukan.');
    }

    return response()->file($path);
}

    //export excel
    public function exportExcel(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        return Excel::download(
            new WisataExport($bulan, $tahun),
            'laporan_permohonan_wisata_edukasi.xlsx'
        );
    }

    public function getSekolah($id)
{
    $sekolah = DataSekolah::findOrFail($id);

    return response()->json([
        'npsn' => $sekolah->npsn,
        'alamat' => $sekolah->alamat,
    ]);
}
}