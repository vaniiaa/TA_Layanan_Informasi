{{-- resources/views/user/p2m/sosialisasi_narkoba.blade.php --}}
@extends('layout.user_bread')
@section('title', 'Permohonan Penyuluhan/Sosialisasi Narkoba')

@section('content')

{{-- Dokumentasi Kegiatan --}}
<div class="w-full md:w-3/4 lg:w-3/4 mx-auto mt-[-50px] mb-10">
    {{-- Grid Foto --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">

        {{-- Foto 1 --}}
        <div class="group relative overflow-hidden rounded-xl shadow-lg">
            <img src="{{ asset('image/giat/p2m_sosialisasi (4).jpg') }}"
                class="w-full h-52 object-cover transform group-hover:scale-110 transition duration-500">

            {{-- Overlay --}}
            <div
                class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                <p class="text-white text-sm font-semibold text-center px-3">
                    Penyuluhan bahaya narkoba di lingkungan masyarakat
                </p>
            </div>
        </div>

        {{-- Foto 2 --}}
        <div class="group relative overflow-hidden rounded-xl shadow-lg">
            <img src="{{ asset('image/giat/p2m_sosialisasi (2).jpg') }}"
                class="w-full h-52 object-cover transform group-hover:scale-110 transition duration-500">

            <div
                class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                <p class="text-white text-sm font-semibold text-center px-3">
                    Edukasi kepada pelajar tentang dampak narkoba
                </p>
            </div>
        </div>

        {{-- Foto 3 --}}
        <div class="group relative overflow-hidden rounded-xl shadow-lg">
            <img src="{{ asset('image/giat/p2m_sosialisasi (3).jpg') }}"
                class="w-full h-52 object-cover transform group-hover:scale-110 transition duration-500">

            <div
                class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                <p class="text-white text-sm font-semibold text-center px-3">
                    Kegiatan sosialisasi sekaligus MPLS di Sekolah </p>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 pt-50 pb-12 relative">

    {{-- Card NOTE --}}
    <div class="bg-white rounded-xl shadow-md border border-[#022D57] p-6
            w-full md:w-3/4 lg:w-3/4 mx-auto mt-[-200px]">
        <h2 class="text-lg font-bold text-gray-800 mb-3">NOTE!!</h2>
        <p class="text-gray-700 text-sm leading-relaxed space-y-2">
            Salam sehat tanpa narkoba!
        </p>
        <ul class="list-decimal list-inside text-sm text-gray-700 mt-2 space-y-1">
            <li>Pengajuan permohonan dikirimkan minimal 1 (satu) minggu sebelum pelaksanaan kegiatan.</li>
            <li>Layanan sosialisasi/penyuluhan tidak dipungut biaya atau GRATIS.</li>
        </ul>
        <p class="text-gray-700 text-sm mt-3">
            Demikian informasi yang dapat kami sampaikan. Terima kasih!
        </p>
        <p class="font-semibold text-gray-800 mt-2">WAR ON DRUGS</p>
    </div>

    {{-- Card Form --}}
    <div class="bg-white rounded-xl shadow-md border border-[#022D57] p-8 mt-5 
            w-full md:w-3/4 lg:w-3/4 mx-auto">
        <h2 class="text-xl font-bold text-[#022D57] mb-4">Data Permohonan</h2>
        <form action="{{ route('sosialisasi.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- Tab Navigation --}}
    <div class="border-b border-gray-200 mb-6">
        <div class="flex flex-wrap">

            <button type="button"
                class="tab-btn px-6 py-3 border-b-2 border-[#022D57] text-[#022D57] font-medium"
                data-tab="pemohon">
                Data Pemohon
            </button>

            <button type="button"
                class="tab-btn px-6 py-3 text-gray-500 font-medium"
                data-tab="kegiatan">
                Detail Kegiatan
            </button>

        </div>
    </div>

    {{-- ================= TAB DATA PEMOHON ================= --}}
    <div id="pemohon" class="tab-content block space-y-2">

        {{-- Nama Lengkap --}}
        <div>
            <label class="block font-medium text-sm text-gray-800 mb-1">
                Nama Lengkap<span class="text-red-500">*</span>
            </label>
            <input type="text" name="nama_lengkap"
                value="{{ old('nama_lengkap') }}" required
                class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#022D57] focus:border-[#022D57]">
        </div>

        {{-- Instansi --}}
        <div>
            <label class="block font-medium text-sm text-gray-800 mb-1">
                Instansi/Organisasi<span class="text-red-500">*</span>
            </label>
            <input type="text" name="instansi"
                value="{{ old('instansi') }}" required
                class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#022D57] focus:border-[#022D57]">
        </div>

        {{-- Alamat --}}
        <div>
            <label class="block font-medium text-sm text-gray-800 mb-1">
                Alamat Instansi<span class="text-red-500">*</span>
            </label>
            <textarea name="alamat" rows="3" required
                class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#022D57] focus:border-[#022D57]">{{ old('alamat') }}</textarea>
        </div>

        {{-- No HP --}}
        <div>
            <label class="block font-medium text-sm text-gray-800 mb-1">
                No HP<span class="text-red-500">*</span>
            </label>
            <input type="tel" name="no_hp"
                value="{{ old('no_hp') }}" required
                class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#022D57] focus:border-[#022D57]">
        </div>

    </div>

    {{-- ================= TAB DETAIL KEGIATAN ================= --}}
    <div id="kegiatan" class="tab-content hidden space-y-2">

        {{-- Nama Kegiatan --}}
        <div>
            <label class="block font-medium text-sm text-gray-800 mb-1">
                Nama Kegiatan<span class="text-red-500">*</span>
            </label>
            <textarea name="nama_kegiatan" required
                class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#022D57] focus:border-[#022D57]">{{ old('nama_kegiatan') }}</textarea>
        </div>

        {{-- Tanggal & Waktu --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block font-medium text-sm text-gray-800 mb-1">
                    Tanggal Kegiatan<span class="text-red-500">*</span>
                </label>
                <input type="date"
                    name="tanggal_kegiatan"
                    value="{{ old('tanggal_kegiatan') }}"
                    required
                    class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#022D57] focus:border-[#022D57]">
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-800 mb-1">
                    Waktu Kegiatan<span class="text-red-500">*</span>
                </label>
                <input type="time"
                    name="waktu_kegiatan"
                    value="{{ old('waktu_kegiatan') }}"
                    required
                    class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#022D57] focus:border-[#022D57]">
            </div>

        </div>

        {{-- Lokasi --}}
        <div>
            <label class="block font-medium text-sm text-gray-800 mb-1">
                Lokasi Kegiatan<span class="text-red-500">*</span>
            </label>
            <textarea name="lokasi" rows="3" required
                class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#022D57] focus:border-[#022D57]">{{ old('lokasi') }}</textarea>
        </div>

        {{-- Peserta --}}
        <div>
            <label class="block font-medium text-sm text-gray-800 mb-1">
                Peserta Kegiatan<span class="text-red-500">*</span>
            </label>

            <select name="peserta" required
                class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#022D57] focus:border-[#022D57]">

                <option value="">-- Pilih Peserta --</option>

                <option value="Instansi Pemerintah"
                    {{ old('peserta') == 'Instansi Pemerintah' ? 'selected' : '' }}>
                    Instansi Pemerintah
                </option>

                <option value="Lingkungan Swasta"
                    {{ old('peserta') == 'Lingkungan Swasta' ? 'selected' : '' }}>
                    Lingkungan Swasta
                </option>

                <option value="Lingkungan Pendidikan"
                    {{ old('peserta') == 'Lingkungan Pendidikan' ? 'selected' : '' }}>
                    Lingkungan Pendidikan
                </option>

                <option value="Lingkungan Masyarakat"
                    {{ old('peserta') == 'Lingkungan Masyarakat' ? 'selected' : '' }}>
                    Lingkungan Masyarakat
                </option>

            </select>
        </div>

        {{-- Jumlah Peserta --}}
        <div>
            <label class="block font-medium text-sm text-gray-800 mb-1">
                Jumlah Peserta<span class="text-red-500">*</span>
            </label>
            <input type="number"
                name="jumlah_peserta"
                value="{{ old('jumlah_peserta') }}"
                placeholder="Contoh: 50"
                required
                class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#022D57] focus:border-[#022D57]">
        </div>

        {{-- Surat Permohonan --}}
        <div>
            <label class="block font-medium text-sm text-gray-800 mb-1">
                Surat Permohonan<span class="text-red-500">*</span>
            </label>

            <input type="file"
                name="surat_permohonan"
                accept=".pdf,.doc,.docx"
                class="w-full border border-gray-300 rounded-md p-2">

            <p class="text-xs text-gray-500 mt-1">
                Format file: <b>PDF, DOC, DOCX</b> • Maksimal ukuran:
                <b>2 MB</b>
            </p>

            @error('surat_permohonan')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Konfirmasi --}}
        <div>
            <label class="flex items-start gap-2 cursor-pointer">

                <input type="checkbox"
                    name="konfirmasi"
                    value="Saya memahami bahwa data yang diisikan dalam formulir ini benar dan bertanggung jawab atas hal tersebut"
                    {{ old('konfirmasi') ? 'checked' : '' }}
                    required
                    class="mt-1 w-4 h-4">

                <span class="text-sm text-gray-700">
                    Saya memahami bahwa data yang diisikan dalam formulir ini
                    benar dan bertanggung jawab atas hal tersebut.
                </span>

            </label>
        </div>

        {{-- Tombol Submit --}}
        <div class="flex justify-end">
            <button type="submit"
                class="bg-[#022D57] hover:bg-[#034077] transition text-white px-6 py-2 rounded-md">
                Kirim
            </button>
        </div>

    </div>
</form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Gagal menambahkan data, silahkan cek kembali inputannya.',
        });

    </script>
@endif
<script>
document.addEventListener('DOMContentLoaded', function () {

    const tabButtons = document.querySelectorAll('.tab-btn');

    const pemohon = document.getElementById('pemohon');
    const kegiatan = document.getElementById('kegiatan');

    tabButtons.forEach(button => {

        button.addEventListener('click', function () {

            const target = this.dataset.tab;

            // reset semua tombol
            tabButtons.forEach(btn => {
                btn.classList.remove(
                    'border-b-2',
                    'border-[#022D57]',
                    'text-[#022D57]'
                );

                btn.classList.add('text-gray-500');
            });

            // aktifkan tombol yg dipilih
            this.classList.add(
                'border-b-2',
                'border-[#022D57]',
                'text-[#022D57]'
            );

            this.classList.remove('text-gray-500');

            // tampilkan tab
            if (target === 'pemohon') {

                pemohon.style.display = 'block';
                kegiatan.style.display = 'none';

            } else {

                pemohon.style.display = 'none';
                kegiatan.style.display = 'block';

            }

        });

    });

});
</script>
@endsection
