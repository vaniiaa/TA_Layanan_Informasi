<?php

namespace App\Http\Controllers;

use App\Models\SosialisasiNarkoba;
use App\Models\WisataEdukasi;
use App\Models\BesukTahanan;
use App\Models\PendaftaranTAT;

class DashboardController extends Controller
{
    //dashboard admin (semua data)
    public function index()
{
    //hitung total data
    //mengamil seluruh jumlah data dari masing-masing tabel
    $totalSosialisasi = SosialisasiNarkoba::count();
    $totalDoemba = WisataEdukasi::count();
    $totalBesukTahanan = BesukTahanan::count();
    $totalPendaftaranTAT = PendaftaranTAT::count();

    // ambil 2 data sosialisasi terbaru
    $sosialisasi = SosialisasiNarkoba::latest()->limit(2)->get()->map(function ($item) {
        $item->jenis_pendaftaran = 'Sosialisasi Narkoba';
        $item->nama_pemohon = $item->nama_lengkap;
        return $item;
    });

    // ambil 2 data wisata edukasi terbaru
    $doemba = WisataEdukasi::latest()->limit(2)->get()->map(function ($item) {
        $item->jenis_pendaftaran = 'DOEMBA';
        $item->nama_pemohon = $item->nama_lengkap;
        return $item;
    });

    // ambil 2 data besuk tahanan terbaru
    $besuk = BesukTahanan::latest()->limit(2)->get()->map(function ($item) {
        $item->jenis_pendaftaran = 'Besuk Tahanan';
        $item->nama_pemohon = $item->nama_pembesuk;
        return $item;
    });

    // ambil 2 data tat terbaru
    $tat = PendaftaranTAT::latest()->limit(2)->get()->map(function ($item) {
        $item->jenis_pendaftaran = 'Assessment Terpadu (TAT)';
        $item->nama_pemohon = $item->nama_lengkap;
        return $item;
    });

    //gabungan semua data riwayat
    $riwayatPendaftaran = collect()
        ->merge($sosialisasi)
        ->merge($doemba)
        ->merge($besuk)
        ->merge($tat)
        ->sortByDesc('created_at')//urutkan dari terbaru
        ->values();

    //kiirim ke view dashboard
    return view('admin.dashboard', compact(
        'totalSosialisasi',
        'totalDoemba',
        'totalBesukTahanan',
        'totalPendaftaranTAT',
        'riwayatPendaftaran'
    ));

    }

    //DASHBOARD USER PEMBERANTASAN
    public function pemberantasan()
    {
        //jumlah seluruh data pada 2 layanan diuser pemberantasan
        $totalBesukTahanan = BesukTahanan::count();
        $totalPendaftaranTAT = PendaftaranTAT::count();

        //data terbaru
        $besuk = BesukTahanan::latest()->limit(5)->get()->map(function ($item) {
            $item->jenis_pendaftaran = 'Besuk Tahanan';
            $item->nama_pemohon = $item->nama_pembesuk;
            return $item;
        });

        $tat = PendaftaranTAT::latest()->limit(5)->get()->map(function ($item) {
            $item->jenis_pendaftaran = 'Assessment Terpadu (TAT)';
            $item->nama_pemohon = $item->nama_lengkap;
            return $item;
        });

        //menggabungkan data riwayat
        $riwayatPendaftaran = collect()
            ->merge($besuk)
            ->merge($tat)
            ->sortByDesc('created_at')
            ->values();

        //kirim ke view
        return view('pemberantasan.dashboard', compact(
            'totalBesukTahanan',
            'totalPendaftaranTAT',
            'riwayatPendaftaran'
        ));
    }

    //DASHBOARD P2M
    public function p2m()
    {
        //jumlah seluruh data layanan p2m
        $totalSosialisasi = SosialisasiNarkoba::count();
        $totalWisata = WisataEdukasi::count();

        //data terbaru
        $sosialisasi = SosialisasiNarkoba::latest()->limit(5)->get()->map(function ($item) {
            $item->jenis_pendaftaran = 'Sosialisasi Narkoba';
            $item->nama_pemohon = $item->nama_lengkap;
            return $item;
        });

        $wisata = WisataEdukasi::latest()->limit(5)->get()->map(function ($item) {
            $item->jenis_pendaftaran = 'Wisata Edukasi';
            $item->nama_pemohon = $item->nama_lengkap;
            return $item;
        });

        //Gabungkan data riwayat
        $riwayatPendaftaran = collect()
            ->merge($sosialisasi)
            ->merge($wisata)
            ->sortByDesc('created_at')
            ->values();
            
        //kirim ke view
        return view('p2m.dashboard', compact(
            'totalSosialisasi',
            'totalWisata',
            'riwayatPendaftaran'
        ));
    }}
