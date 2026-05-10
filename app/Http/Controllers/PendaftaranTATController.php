<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranTAT;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PendaftaranTATExport;

class PendaftaranTATController extends Controller
{
    //menampilkan halaman form pendaftaran tat untuk user
    public function create()
    {
        return view('user.pemberantasan.assessment_terpadu');
    }

    //menyimpan data
    public function store(Request $request)
    {
        //validasi semua inputan
        $validated = $request->validate([
            'nama_lengkap' => 'required',
            'nik' => 'required|unique:pendaftaran_tat,nik',
            'alamat' => 'required',
            'instansi' => 'required',
            'nama_penyidik' => 'required',
            'wa_penyidik' => 'required',
            'tanggal_surat_pengajuan' => 'required|date',
            'tanggal_lp' => 'required|date',
            'tanggal_penangkapan' => 'required|date',
            'nama_tersangka' => 'required',
            'konfirmasi' => 'required',
            'berat_barang_bukti' => 'nullable|string',
            'file_surat_permohonan' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'file_lp' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'file_penangkapan' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'file_identitas' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'barang_bukti' => 'required|array|min:1',
            'hasil_urine' => 'required|array|min:1',
            'berat_barang_bukti' => 'required|string',],
            [
            //pesan errorr
            'required' => ':attribute wajib diisi.',
            'date' => ':attribute harus berupa tanggal yang valid.',
            //validasi checkbox
            'barang_bukti.required' => 'Barang bukti narkoba wajib dipilih minimal satu.',
            'barang_bukti.min' => 'Barang bukti narkoba wajib dipilih minimal satu.',
            //validasi format file hasil tes urine
            'hasil_urine.required' => 'Hasil tes urine wajib dipilih minimal satu.',
            'hasil_urine.min' => 'Hasil tes urine wajib dipilih minimal satu.',
            //validasi format file
            'file_surat_permohonan.mimes' => 'Surat permohonan harus berupa file PDF, DOC, atau DOCX.',
            'file_lp.mimes' => 'Laporan polisi harus berupa file PDF, DOC, atau DOCX.',
            'file_penangkapan.mimes' => 'Surat penangkapan harus berupa file PDF, DOC, atau DOCX.',
            'file_identitas.mimes' => 'File identitas harus berupa PDF, DOC, atau DOCX.',
            //validasi ukuran file
            'file_surat_permohonan.max' => 'Surat permohonan tidak boleh lebih dari 2 MB.',
            'file_lp.max' => 'Laporan polisi tidak boleh lebih dari 2 MB.',
            'file_penangkapan.max' => 'Surat penangkapan tidak boleh lebih dari 2 MB.',
            'file_identitas.max' => 'File identitas tidak boleh lebih dari 2 MB.',
        ]
    );

        // Upload file
        //cek dan simpan file surat permohonan
        if ($request->hasFile('file_surat_permohonan')) {
            $validated['file_surat_permohonan'] =
                $request->file('file_surat_permohonan')->store('tat/surat_permohonan', 'public');
        }

        //cek dan simpan file laporan polisi
        if ($request->hasFile('file_lp')) {
            $validated['file_lp'] =
                $request->file('file_lp')->store('tat/lp', 'public');
        }

        //cek dan simpan file penangkapan
        if ($request->hasFile('file_penangkapan')) {
            $validated['file_penangkapan'] =
                $request->file('file_penangkapan')->store('tat/penangkapan', 'public');
        }

        //cek dan simpan file identitas
        if ($request->hasFile('file_identitas')) {
            $validated['file_identitas'] =
                $request->file('file_identitas')->store('tat/identitas', 'public');
        }

        // CHECKBOX
        $validated['barang_bukti'] = $request->input('barang_bukti', []);
        $validated['hasil_urine'] = $request->input('hasil_urine', []);

        //simpan semua data ke tabel pendaftaran_tat
        PendaftaranTAT::create($validated);

        return redirect()->route('tat.konfirmasi')->with([
            'nama_lengkap' => $request->nama_lengkap,
            'tanggal_pendaftaran' => now()->format('d-m-Y'),
        ]);
    }

    //menampilkan halaman tat untuk user admin
    public function indexAdmin(Request $request)
    {
        $query = PendaftaranTAT::query();

        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

            $data = $query->latest()->paginate(10);

        return view('admin.pemberantasan.assessment', compact('data'));
    }

    //download file
    public function downloadFile($id, $field)
    {
        //ambil data berdasarkan ID
        $data = PendaftaranTAT::findOrFail($id);

        if (!$data->$field) {
            abort(404, 'File tidak ditemukan.');
        }

        $path = storage_path('app/public/' . $data->$field);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->download($path, basename($path));
    }

    //menampilkan file dibrowser
    public function viewFile($id, $field)
    {
        $data = PendaftaranTAT::findOrFail($id);

        if (!$data->$field) {
            abort(404, 'File tidak ditemukan.');
        }

        $path = storage_path('app/public/' . $data->$field);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->file($path);
    }

    //bukti PDF
   public function downloadBukti()
{
    // Ambil data TAT TERAKHIR
    $tat = PendaftaranTAT::latest()->first();
    //jika tidak ada data
    if (!$tat) {
        abort(404, 'Data pendaftaran tidak ditemukan');
    }

    //siapkan data utk pdf
    $data = [
        'nama_lengkap'    => $tat->nama_lengkap,
        'tanggal'=> $tat->created_at->format('d-m-Y'),
    ];

    $pdf = Pdf::loadView(
                'user.pemberantasan.bukti_pdf_assessment',
                $data
           )->setPaper('A5', 'portrait'); 
    //download file pdf
    return $pdf->download(
        'Bukti_Pendaftaran_TAT.pdf'
    );
}

    //export excel
    public function exportLaporan(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        return Excel::download(
            new PendaftaranTATExport($bulan, $tahun),
            'laporan_pendaftaran_tat.xlsx'
        );
    }

    //menampilkan halaman tat untuk user Pemberantasan
    public function indexPemberantasan(Request $request)
    {   
        $query = PendaftaranTAT::query();

        //filter bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }
        //filter tahun
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }
        //ambil data terbaru dan pagination
        $data = $query->latest()->paginate(10);

        //tampilkan ke view pemberantasan
        return view('pemberantasan.assessment', compact('data'));
    }}
