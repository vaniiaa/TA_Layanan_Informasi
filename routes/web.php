<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SosialisasiNarkobaController;
use App\Http\Controllers\WisataEdukasiController;
use App\Http\Controllers\BesukTahananController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MateriEdukasiController;
use App\Http\Controllers\PublikasiBeritaController;
use App\Http\Controllers\PendaftaranTATController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DataSekolahController;
use App\Http\Controllers\DataTahananController;
use App\Http\Controllers\UserController;

Route::resource('users', UserController::class);

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

//ADMIN
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', 
        [ProfileController::class, 'index'])
        ->name('profile');

    Route::post('/profile/update', 
        [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::get('/tambah_akun', [UserController::class, 'create'])
    ->name('tambah_akun');

    Route::post('/tambah_akun/store', [UserController::class, 'store'])
    ->name('tambah_akun.store');

    Route::put('/users/{id}', [UserController::class, 'update'])
    ->name('users.update');

    Route::delete('/users/{id}', [UserController::class, 'destroy'])
    ->name('users.destroy');

    /* --- P2M ADMIN --- */
    //sosialisasi narkoba
    Route::get('/p2m/sosialisasi', 
        [SosialisasiNarkobaController::class, 'index'])
        ->name('sosialisasi.index');

    Route::get('/p2m/sosialisasi/{id}/view_surat',
        [SosialisasiNarkobaController::class, 'viewSurat'])
        ->name('sosialisasi.view_surat');

    Route::get('/p2m/sosialisasi/{id}/download-surat',
        [SosialisasiNarkobaController::class, 'downloadSurat'])
        ->name('sosialisasi.download_surat');

    Route::get('/p2m/sosialisasi/export', 
       [SosialisasiNarkobaController::class, 'exportExcel'])
       ->name('laporan.export.sosialisasi');

    //wisata edukasi
    Route::get('/p2m/kunjungan_wisata', 
        [WisataEdukasiController::class, 'index'])
        ->name('p2m.kunjungan_wisata.index');

    Route::get('/p2m/wisata/surat/{id}/view', 
        [WisataEdukasiController::class, 'viewSurat'])
        ->name('wisata.viewSurat');

    Route::get('/p2m/wisata/surat/{id}/download', 
        [WisataEdukasiController::class, 'downloadSurat'])
        ->name('wisata.downloadSurat');
    
    Route::get('/p2m/kunjungan_wisata/export',  
        [WisataEdukasiController::class, 'exportExcel'])
        ->name('laporan.export.wisata');
    
    //materi edukasi
    Route::get('/p2m/materi_edukasi', 
        [MateriEdukasiController::class, 'index'])
        ->name('materi.index');

    Route::post('/p2m/materi_edukasi', 
        [MateriEdukasiController::class, 'store'])
        ->name('materi.store');

    Route::put('/p2m/materi_edukasi/{id}', 
        [MateriEdukasiController::class, 'update'])
        ->name('materi.update');

    Route::delete('/p2m/materi_edukasi/{id}', 
        [MateriEdukasiController::class, 'destroy'])
        ->name('materi.destroy');

    // data sekolah
    Route::get('/p2m/data_sekolah', 
        [DataSekolahController::class, 'index'])
        ->name('data_sekolah.index');

    Route::post('/p2m/data_sekolah', 
        [DataSekolahController::class, 'store'])
        ->name('data_sekolah.store');

    Route::put('/p2m/data_sekolah/{id}', 
        [DataSekolahController::class, 'update'])
        ->name('data_sekolah.update');

    Route::delete('/p2m/data_sekolah/{id}', 
        [DataSekolahController::class, 'destroy'])
        ->name('data_sekolah.delete');

    /* --- PEMBERANTASAN ADMIN --- */
    //besuk tahanan
    Route::get('/pemberantasan/besuk_tahanan', 
        [BesukTahananController::class, 'indexAdmin'])
        ->name('pemberantasan.besuk_tahanan');

    Route::get('/user/tahanan/search', 
        [BesukTahananController::class, 'searchTahanan'])
        ->name('user.tahanan.search');

    Route::get('/pemberantasan/besuk_tahanan/identitas/{id}/view',
        [BesukTahananController::class, 'viewSurat'])
        ->name('besuk_tahanan.viewSurat');

    Route::get('/pemberantasan/besuk_tahanan/identitas/{id}/download',
        [BesukTahananController::class, 'downloadSurat'])
        ->name('besuk_tahanan.downloadSurat');

    Route::get('/pemberantasan/besuk_tahanan/export',  
        [BesukTahananController::class, 'exportLaporan'])
        ->name('laporan.export_besuk');

    //data tahanan    
    Route::get('/pemberantasan/data_tahanan', 
        [DataTahananController::class, 'index'])
        ->name('pemberantasan.data_tahanan');

    Route::post('/pemberantasan/data_tahanan/store', 
        [DataTahananController::class, 'store'])
        ->name('pemberantasan.data_tahanan.store');

    Route::put('/pemberantasan/data_tahanan/update/{id}', 
        [DataTahananController::class, 'update'])
        ->name('pemberantasan.data_tahanan.update');

    Route::delete('/pemberantasan/data_tahanan/delete/{id}', 
        [DataTahananController::class, 'destroy'])
        ->name('pemberantasan.data_tahanan.destroy');

    //publikasi berita
    Route::get('/pemberantasan/publikasi_berita', function () {
            return view('/admin/pemberantasan/publikasi_berita');    
        });

    Route::get('/pemberantasan/publikasi_berita', 
        [PublikasiBeritaController::class, 'index'])
        ->name('publikasi.index');

    Route::post('/pemberantasan/publikasi_berita', 
        [PublikasiBeritaController::class, 'store'])
        ->name('publikasi.store');

    Route::put('/pemberantasan/publikasi_berita/{id}', 
        [PublikasiBeritaController::class, 'update'])
        ->name('publikasi.update');

    Route::delete('/pemberantasan/publikasi_berita/{id}', 
        [PublikasiBeritaController::class, 'destroy'])
        ->name('publikasi.destroy');

    //assessment terpadu
    Route::get('/pemberantasan/assessment', 
        [PendaftaranTATController::class, 'indexAdmin'])
        ->name('pemberantasan.assessment');

    Route::get('/pemberantasan/assessment/bukti/{id}', 
        [PendaftaranTATController::class, 'downloadBukti'])
        ->name('assessment.bukti');

    Route::get('/pemberantasan/assessment/file/{id}/{field}', 
        [PendaftaranTATController::class, 'downloadFile'])
        ->name('assessment.file.download');

    Route::get('/pemberantasan/assessment/file/view/{id}/{field}', 
        [PendaftaranTATController::class, 'viewFile'])
        ->name('assessment.file.view');

    Route::get('/pemberantasan/assessment/export', 
        [PendaftaranTATController::class, 'exportLaporan'])
        ->name('assessment.export');
});


//USER PEMBERANTASAN
Route::middleware(['auth'])
    ->prefix('pemberantasan')
    ->name('pemberantasan.')
    ->group(function () {

    Route::get('/dashboard', 
        [DashboardController::class, 'pemberantasan'])
        ->name('dashboard');

    Route::get('/profile', 
        [ProfileController::class, 'index'])
        ->name('profile');

    Route::post('/profile/update', 
        [ProfileController::class, 'update'])
        ->name('profile.update');

    //data tahanan
    Route::get('/data_tahanan',
        [DataTahananController::class,'pemberantasanIndex'])
        ->name('data_tahanan');

    Route::post('/data_tahanan/store',
        [DataTahananController::class,'store'])
        ->name('data_tahanan.store');

    Route::put('/data_tahanan/update/{id}',
        [DataTahananController::class,'update'])
        ->name('data_tahanan.update');

    Route::delete('/data_tahanan/delete/{id}',
        [DataTahananController::class,'destroy'])
        ->name('data_tahanan.destroy');

    //publikasi berita
     Route::get('/publikasi_berita',
        [PublikasiBeritaController::class,'pemberantasanIndex'])
        ->name('publikasi');

    Route::post('/publikasi_berita/store',
        [PublikasiBeritaController::class,'store'])
        ->name('publikasi.store');  

    Route::put('/publikasi_berita/update/{id}',
        [PublikasiBeritaController::class,'update'])
        ->name('publikasi.update');

    Route::delete('/publikasi_berita/delete/{id}',
        [PublikasiBeritaController::class,'destroy'])
        ->name('publikasi.destroy');

    //besuk tahanan
     Route::get('/besuk_tahanan', 
        [BesukTahananController::class,'indexPemberantasan'])
        ->name('besuk_tahanan');

    Route::get('/besuk_tahanan/view/{id}', 
        [BesukTahananController::class,'viewSurat'])
        ->name('besuk_tahanan.viewSurat');

    Route::get('/besuk_tahanan/download/{id}', 
        [BesukTahananController::class,'downloadSurat'])
        ->name('besuk_tahanan.downloadSurat');

    Route::get('/besuk_tahanan/export', 
        [BesukTahananController::class,'exportLaporan'])
        ->name('besuk_tahanan.export');

    //asessment terpadu
    Route::get('/assessment', 
        [PendaftaranTATController::class,'indexPemberantasan'])
        ->name('assessment');

    Route::get('/assessment/export', 
        [PendaftaranTATController::class,'exportLaporan'])
        ->name('assessment.export');

    Route::get('/assessment/view/{id}/{field}', 
        [PendaftaranTATController::class,'viewFile'])
        ->name('assessment.view');

    Route::get('/assessment/download/{id}/{field}', 
        [PendaftaranTATController::class,'downloadFile'])
        ->name('assessment.download');
});


//USER P2M
Route::middleware(['auth'])
    ->prefix('p2m')
    ->name('p2m.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', 
            [DashboardController::class, 'p2m'])
            ->name('dashboard');

        // Profile
        Route::get('/profile', 
            [ProfileController::class, 'index'])
            ->name('profile');

        Route::post('/profile/update', 
            [ProfileController::class, 'update'])
            ->name('profile.update');

        // Data Sekolah
        Route::get('/data_sekolah', 
            [DataSekolahController::class, 'p2mIndex'])
            ->name('data_sekolah');

        Route::post('/data_sekolah/store', 
            [DataSekolahController::class, 'store'])
            ->name('data_sekolah.store');

        Route::put('/data_sekolah/update/{id}', 
            [DataSekolahController::class, 'update'])
            ->name('data_sekolah.update');

        Route::delete('/data_sekolah/delete/{id}', 
            [DataSekolahController::class, 'destroy'])
            ->name('data_sekolah.delete');

        // Sosialisasi
        Route::get('/sosialisasi', 
            [SosialisasiNarkobaController::class, 'indexP2M'])
            ->name('sosialisasi.indexP2M');

        Route::get('/sosialisasi/view/{id}', 
            [SosialisasiNarkobaController::class, 'viewSurat'])
            ->name('sosialisasi.view_surat');

        Route::get('/sosialisasi/download/{id}', 
            [SosialisasiNarkobaController::class, 'downloadSurat'])
            ->name('sosialisasi.download_surat');

        Route::get('/sosialisasi/export', 
            [SosialisasiNarkobaController::class, 'exportExcel'])
            ->name('laporan.export.sosialisasi');

        // Wisata edukasi
        Route::get('/kunjungan_wisata', 
            [WisataEdukasiController::class, 'indexWisata'])
            ->name('kunjungan_wisata.indexWisata');

        Route::get('/kunjungan_wisata/view/{id}', 
            [WisataEdukasiController::class, 'viewSurat'])
            ->name('kunjungan_wisata.view_surat');

        Route::get('/kunjungan_wisata/download/{id}', 
            [WisataEdukasiController::class, 'downloadSurat'])
            ->name('kunjungan_wisata.download_surat');

        Route::get('/kunjungan_wisata/export', 
            [WisataEdukasiController::class, 'exportExcel'])
            ->name('laporan.export.kunjungan_wisata');

        // Materi Edukasi
        Route::get('/materi_edukasi', 
            [MateriEdukasiController::class, 'indexMateri'])
            ->name('materi_edukasi');

        Route::post('/materi_edukasi/store', 
            [MateriEdukasiController::class, 'store'])
            ->name('materi_edukasi.store');

        Route::put('/materi_edukasi/update/{id}', 
            [MateriEdukasiController::class, 'update'])
            ->name('materi_edukasi.update');

        Route::delete('/materi_edukasi/delete/{id}', 
            [MateriEdukasiController::class, 'destroy'])
            ->name('materi_edukasi.destroy');
    });


//USER ATAU PENGGUNA
Route::get('/', function () {
    return view('dashboard');
});

// USER - SOSIALISASI
Route::get('/user/p2m/sosialisasi_narkoba', function () {
    return view('user.p2m.sosialisasi_narkoba');
    });

Route::post('/user/p2m/sosialisasi/store', 
    [SosialisasiNarkobaController::class, 'store'])
    ->name('sosialisasi.store');

Route::get('/sosialisasi/view/{id}', 
    [SosialisasiNarkobaController::class, 'viewSurat'])
    ->name('sosialisasi.view_surat');

Route::get('/user/p2m/konfirmasi', function () {
    return view('user.p2m.konfirmasi');
    })->name('sosialisasi.konfirmasi');

Route::get('/user/p2m/konfirmasi/download', 
    [SosialisasiNarkobaController::class, 'downloadBukti'])
    ->name('sosialisasi.download');

// USER - WISATA EDUKASI
Route::get('/user/p2m/wisata_edukasi', 
    [WisataEdukasiController::class, 'create'])
    ->name('wisata_edukasi.create');

Route::post('/user/p2m/wisata_edukasi', 
    [WisataEdukasiController::class, 'store'])
    ->name('wisata_edukasi.store');

Route::get('/user/p2m/konfirmasi_wisata', 
    [WisataEdukasiController::class, 'konfirmasi'])
    ->name('wisata.konfirmasi');

Route::get('/user/p2m/download-bukti', 
    [WisataEdukasiController::class, 'downloadBukti'])
    ->name('wisata.downloadBukti');

Route::get('/get-sekolah/{id}', 
    [WisataEdukasiController::class, 'getSekolah']);

// USER - MATERI EDUKASI
Route::get('/user/p2m/materi_edukasi', 
    [MateriEdukasiController::class, 'userIndex'])
    ->name('user.materi.index');

Route::get('/user/p2m/detail_materi_edukasi/{id}', 
    [MateriEdukasiController::class, 'userDetail']
)->name('user.p2m.detail_materi_edukasi');

// USER - BESUK TAHANAN
Route::get('/user/pemberantasan/besuk_tahanan', function () {
    return view('user.pemberantasan.besuk_tahanan');
});

Route::post('/besuk/store', 
    [BesukTahananController::class, 'store'])
    ->name('besuk.store');
    
Route::get('/user/pemberantasan/konfirmasi', function () {
    return view('user.pemberantasan.konfirmasi');
    })->name('konfirmasi.besuk');

Route::get('/user/pemberantasan/download-bukti',
    [BesukTahananController::class, 'downloadBukti'])
    ->name('besuk.downloadBukti');

Route::get('/user/tahanan/search', [BesukTahananController::class, 'searchTahanan'])
    ->name('user.tahanan.search');

Route::get('/cek-nomor-tahanan', [BesukTahananController::class, 'cekNomorTahanan']);    

// USER - ASSESSMENT
Route::get('/user/pemberantasan/assessment_terpadu', 
    [PendaftaranTATController::class, 'create'])
    ->name('tat.create');

Route::post('/tat/store', 
    [PendaftaranTATController::class, 'store'])
    ->name('tat.store');

Route::get('/user/pemberantasan/konfirmasi_tat', function () {
    return view('user.pemberantasan.konfirmasi_assessment');
})->name('tat.konfirmasi');

Route::get('/tat/bukti', 
    [PendaftaranTATController::class, 'downloadBukti'])
    ->name('tat.downloadBukti');

// USER - PUBLIKASI BERITA
Route::get('/user/pemberantasan/publikasi_berita', 
    [PublikasiBeritaController::class, 'userIndex'])
    ->name('user.publikasi.index');

Route::get('/user/pemberantasan/detail_publikasi_berita', function () {
    return view('user.pemberantasan.detail_publikasi_berita');
});

Route::get('/user/pemberantasan/detail_publikasi_berita/{id}', 
    [PublikasiBeritaController::class, 'userDetail'])
    ->name('user.pemberantasan.detail_publikasi_berita');
    