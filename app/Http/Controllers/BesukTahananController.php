<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BesukTahanan;
use App\Models\DataTahanan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\BesukTahananExport;
use Maatwebsite\Excel\Facades\Excel;

class BesukTahananController extends Controller
{
    //menyimpan data pendaftaran besuk tahanan dari form user
    public function store(Request $request)
    {
    //validasi semua input dari form
    $request->validate([

        'hari_kunjungan' => 'required',
        'tanggal_kedatangan' => 'required|date',
        'self_assessment' => 'required|string',
        'nama_pembesuk' => 'required|string',
        'tahanan_id' => 'required|exists:data_tahanan,id',
        'alamat_pembesuk' => 'required|string',
        'no_hp' => 'required|string',
        'jam_masuk' => 'required',
        'hubungan' => 'required',
        'foto_identitas' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'barang' =>  'required|array|min:1',],
        [
        //validasi khusus barang bawaan
        'barang.required' => 'Barang yang dibawa wajib dipilih minimal satu.',
        'barang.min' => 'Barang yang dibawa wajib dipilih minimal satu.',
        //validasi file foto identitas
        'foto_identitas.required' => 'Foto identitas wajib diupload.',
        'foto_identitas.image' => 'File harus berupa gambar.',
        'foto_identitas.mimes' => 'Format file harus JPG, JPEG, atau PNG.',
        'foto_identitas.max' => 'Ukuran file maksimal 2 MB.',
    ]);

    //simpan file foto ke storage/identitas
    $foto = $request->file('foto_identitas')->store('identitas', 'public');
$tahanan = DataTahanan::find($request->tahanan_id);

if (!$tahanan) {
    return back()->withErrors(['tahanan_id' => 'Data tahanan tidak ditemukan']);
}

// simpan data ke database
$besuk = BesukTahanan::create([
    'tahanan_id' => $request->tahanan_id,
    'hari_kunjungan' => $request->hari_kunjungan,
    'tanggal_kedatangan' => $request->tanggal_kedatangan,
    'self_assessment' => $request->self_assessment,
    'nama_pembesuk' => $request->nama_pembesuk,
    'nama_tahanan' => $tahanan->nama_tahanan,
    'alamat_pembesuk' => $request->alamat_pembesuk,
    'no_hp' => $request->no_hp,
    'jam_masuk' => $request->jam_masuk,
    'hubungan' => $request->hubungan,
    'foto_identitas' => $foto,
    'barang' => $request->barang ? implode(',', $request->barang) : null,
]);
    //simpan data sementara ke session untuk bukti PDF
    session([
        'nama_pembesuk' => $besuk->nama_pembesuk,
        'tanggal_pendaftaran' => now()->format('d-m-Y'),
    ]);

    //redirect kehalaman konfirmasi
    return redirect()->route('konfirmasi.besuk');
}

    //menampilkan halaman konfirmasi setelah pendaftaran berhasil
    public function konfirmasi()
    {
        return view('user.pemberantasan.konfirmasi');
    }
    
    //download bukti pendaftaran dalam PDF
   public function downloadBukti()
   {
    $nama = session('nama_pembesuk');
    $tanggal = session('tanggal_pendaftaran');

    // Jika session hilang
    if (!$nama || !$tanggal) {
        return redirect('/user/pemberantasan/besuk_tahanan');
    }

    $pdf = Pdf::loadView(
                'user.pemberantasan.bukti_pdf',
                compact('nama', 'tanggal')
           )->setPaper('A5', 'portrait'); 

    return $pdf->download('Bukti_Pendaftaran_Besuk_Tahanan.pdf');
}

    //menampilkan halaman data besuk tahanan untuk user Pemberantasan
    public function indexPemberantasan(Request $request)
    {
        $query = BesukTahanan::query();
        //filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }
        //filter berdasarkan tahun
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        $data = $query->latest()->paginate(10);

        return view('pemberantasan.besuk_tahanan', compact('data'));
    }

    //menampilkan halaman data besuk tahanan untuk user Admin
    public function indexAdmin(Request $request)
    {
        $query = BesukTahanan::query();

        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        $data = $query->latest()->paginate(10);

        return view('admin.pemberantasan.besuk_tahanan', compact('data'));
    }

    //admin melakukan download file identitas dari storage
    public function downloadSurat($id)
    {
        $data = BesukTahanan::findOrFail($id);
        $path = storage_path('app/public/' . $data->foto_identitas);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->download($path, basename($path));
    }

    // admin melihat file foto identitas langsung dari browser
    public function viewSurat($id)
    {
        $data = BesukTahanan::findOrFail($id);
        $path = storage_path('app/public/' . $data->foto_identitas);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->file($path);
    }

    //admin export data beuk tahanan ke Excel
    public function exportLaporan(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        return Excel::download(
            new BesukTahananExport($bulan, $tahun),
            'laporan_besuk_tahanan.xlsx'
        );} 

    //search datatahanan untuk form besuk tahanan
    public function searchTahanan(Request $request)
    {
        $q = $request->get('q');
        $tahanan = \App\Models\DataTahanan::where('nama_tahanan', 'like', "%{$q}%")
                    ->orWhere('nomor_tahanan', 'like', "%{$q}%")
                    ->limit(10)
                    ->get();

        return response()->json($tahanan);
    }
    public function cekNomorTahanan(Request $request)
{
    $tahanan = DataTahanan::where('nomor_tahanan', $request->nomor_tahanan)->first();

    return response()->json($tahanan);
}
}
