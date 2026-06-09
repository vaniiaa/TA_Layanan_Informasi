{{-- resources/views/user/pemberantasan/assessment_terpadu.blade.php --}}
@extends('layout.user_bread')
@section('title', 'Pendaftaran Assessment Terpadu (TAT)')

@section('content')
{{-- Dokumentasi Kegiatan --}}
<div class="w-full md:w-3/4 lg:w-3/4 mx-auto mt-[-50px] mb-10">
    {{-- Grid Foto --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">

        {{-- Foto 1 --}}
        <div class="group relative overflow-hidden rounded-xl shadow-lg">
            <img src="{{ asset('image/giat/pemberantasan_tat (1).jpeg') }}"
                class="w-full h-52 object-cover transform group-hover:scale-110 transition duration-500">

            {{-- Overlay --}}
            <div
                class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                <p class="text-white text-sm font-semibold text-center px-3">
                    Assessment Terpadu yang dilakukan oleh Tim Hukum
                </p>
            </div>
        </div>

        {{-- Foto 2 --}}
        <div class="group relative overflow-hidden rounded-xl shadow-lg">
            <img src="{{ asset('image/giat/pemberantasan_tat (2).jpeg') }}"
                class="w-full h-52 object-cover transform group-hover:scale-110 transition duration-500">

            <div
                class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                <p class="text-white text-sm font-semibold text-center px-3">
                    Assessment Terpadu yang dilakukan oleh Tim Medis
                </p>
            </div>
        </div>

        {{-- Foto 3 --}}
        <div class="group relative overflow-hidden rounded-xl shadow-lg">
            <img src="{{ asset('image/giat/pemberantasan_tat (3).jpeg') }}"
                class="w-full h-52 object-cover transform group-hover:scale-110 transition duration-500">

            <div
                class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                <p class="text-white text-sm font-semibold text-center px-3">
                    Assessment Terpadu pada proses Case Conference</p>
            </div>
        </div>

    </div>
</div>
<div class="container mx-auto px-4 pt-50 pb-12 relative">

    {{-- Card NOTE --}}
    <div class="bg-white rounded-xl shadow-md border border-[#022D57] p-6
        w-full md:w-3/4 lg:w-3/4 mx-auto mt-[-200px]">
        <h2 class="text-lg font-bold text-black mb-3">NOTE!!</h2>
        <p class="text-gray-700 text-sm leading-relaxed space-y-2"> Salam sehat tanpa narkoba! </p>
        <p class="text-gray-700 text-sm leading-relaxed space-y-2">Berikut adalah formulir Permohonan Pelaksanaan
            Kegiatan Assessment Terpadu di BNNP Kepri, terdapat beberapa hal yang harus diperhatikan:</p>
        <ul class="list-decimal list-inside text-sm text-gray-700 mt-2 space-y-1">
            <li>Waktu Pelaksanaan TAT (6x24 Jam) dari waktu terbit Surat Penangkapan (termasuk hari libur dan tanggal
                merah). </li>
            <li>Waktu dan Jadwal Pelaksanaan Assessment Terpadu akan di informasikan oleh Sekretariat (Bid.Pemberantasan
                Sie. Wastahti BNNP Kepri).</li>
            <li>Dokumen Persyaratan dalam bentuk hardcopy diserahkan kepada sekretariat sebanyak 2 rangkap.</li>
            <li>Layanan Assessment Terpadu tidak dipungut biaya atau GRATIS.</li>
        </ul>
        <p class="text-gray-700 text-sm mt-3"> Demikian informasi yang dapat kami sampaikan. Terima kasih! </p>
        <p class="font-semibold text-gray-800 mt-2">WAR ON DRUGS</p>
    </div>

    {{-- FORM START --}}
    <form action="{{ route('tat.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-xl shadow-md border border-[#022D57] p-8 mt-5
        w-full md:w-3/4 lg:w-3/4 mx-auto">

            {{-- Judul --}}
            <h2 class="text-xl font-bold text-[#022D57] mb-4">
                Permohonan TAT
            </h2>

            {{-- Tab Navigation --}}
            <div class="border-b border-gray-200 mb-6">
                <div class="flex flex-wrap">

                    <button type="button"
                        class="tab-btn px-6 py-3 border-b-2 border-[#022D57] text-[#022D57] font-medium"
                        data-tab="pendaftaran">
                        Data Pendaftaran
                    </button>

                    <button type="button" class="tab-btn px-6 py-3 text-gray-500 font-medium" data-tab="tersangka">
                        Identitas Tersangka
                    </button>

                </div>
            </div>

            {{-- TAB 1 --}}
            <div id="pendaftaran" class="tab-content block space-y-2">


                <div class="space-y-5">
                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="block font-medium text-sm mb-1">Nama Lengkap<span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                            required class="w-full border border-gray-300 rounded-md p-2">
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label class="block font-medium text-sm mb-1">Alamat<span class="text-red-500">*</span></label>
                        <input type="text" name="alamat" value="{{ old('alamat') }}" required
                            class="w-full border border-gray-300 rounded-md p-2">
                    </div>

                    {{-- Instansi --}}
                    <div>
                        <label class="block font-medium text-sm mb-1">Instansi<span
                                class="text-red-500">*</span></label>
                        <select name="instansi" class="w-full border border-gray-300 rounded-md p-2" required>
                            <option value="">-- Pilih Instansi --</option>

                            <option value="POLDA KEPRI"
                                {{ old('instansi') == 'POLDA KEPRI' ? 'selected' : '' }}>
                                POLDA KEPRI
                            </option>

                            <option value="POLDA BARELANG"
                                {{ old('instansi') == 'POLDA BARELANG' ? 'selected' : '' }}>
                                POLDA BARELANG
                            </option>

                            <option value="POLRES TANJUNGPINANG"
                                {{ old('instansi') == 'POLRES TANJUNGPINANG' ? 'selected' : '' }}>
                                POLRES TANJUNGPINANG
                            </option>

                            <option value="POLRES TANJUNG BALAI KARIMUN"
                                {{ old('instansi') == 'POLRES TANJUNG BALAI KARIMUN' ? 'selected' : '' }}>
                                POLRES TANJUNG BALAI KARIMUN
                            </option>

                            <option value="POLRES BINTAN"
                                {{ old('instansi') == 'POLRES BINTAN' ? 'selected' : '' }}>
                                POLRES BINTAN
                            </option>
                        </select>
                    </div>

                    {{-- Nama Penyidik --}}
                    <div>
                        <label class="block font-medium text-sm mb-1">Nama Penyidik<span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama_penyidik" value="{{ old('nama_penyidik') }}"
                            required class="w-full border border-gray-300 rounded-md p-2">
                    </div>

                    {{-- No Telepon Penyidik --}}
                    <div>
                        <label class="block font-medium text-sm mb-1">No Telepon Penyidik<span
                                class="text-red-500">*</span></label>
                        <input type="text" name="wa_penyidik" value="{{ old('wa_penyidik') }}"
                            required class="w-full border border-gray-300 rounded-md p-2">
                    </div>

                    {{-- Tanggal Surat Pengajuan --}}
                    <div>
                        <label class="block font-medium text-sm mb-1">Tanggal Surat Pengajuan<span
                                class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_surat_pengajuan"
                            value="{{ old('tanggal_surat_pengajuan') }}" required
                            class="w-full border border-gray-300 rounded-md p-2">
                    </div>

                    {{-- Surat Permohonan --}}
                    <div>
                        <label class="block font-medium text-sm text-gray-800 mb-1">
                            Surat Permohonan<span class="text-red-500">*</span>
                        </label>

                        <input type="file" name="file_surat_permohonan" accept=".pdf,.doc,.docx"
                            class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#022D57] focus:border-[#022D57]">

                        <p class="text-xs text-gray-500 mt-1">
                            Format file: <b>PDF, DOC, DOCX</b> • Maksimal ukuran: <b>2 MB</b>
                        </p>

                        @error('file_surat_permohonan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal Laporan Polisi --}}
                    <div>
                        <label class="block font-medium text-sm mb-1">Tanggal Laporan Polisi<span
                                class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_lp" value="{{ old('tanggal_lp') }}" required
                            class="w-full border border-gray-300 rounded-md p-2">
                    </div>

                    {{-- Laporan Polisi --}}
                    <div>
                        <label class="block font-medium text-sm text-gray-800 mb-1">
                            Laporan Polisi<span class="text-red-500">*</span>
                        </label>

                        <input type="file" name="file_lp" accept=".pdf,.doc,.docx"
                            class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#022D57] focus:border-[#022D57]">

                        <p class="text-xs text-gray-500 mt-1">
                            Format file: <b>PDF, DOC, DOCX</b> • Maksimal ukuran: <b>2 MB</b>
                        </p>

                        @error('file_lp')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal Penangkapan --}}
                    <div>
                        <label class="block font-medium text-sm mb-1">Tanggal Penangkapan<span
                                class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_penangkapan"
                            value="{{ old('tanggal_penangkapan') }}" required
                            class="w-full border border-gray-300 rounded-md p-2">
                    </div>

                    {{-- Surat Penangkapan --}}
                    <div>
                        <label class="block font-medium text-sm text-gray-800 mb-1">
                            Surat Penangkapan<span class="text-red-500">*</span>
                        </label>

                        <input type="file" name="file_penangkapan" accept=".pdf,.doc,.docx"
                            class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#022D57] focus:border-[#022D57]">

                        <p class="text-xs text-gray-500 mt-1">
                            Format file: <b>PDF, DOC, DOCX</b> • Maksimal ukuran: <b>2 MB</b>
                        </p>

                        @error('file_penangkapan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- IDENTITAS TERSANGKA --}}
            {{-- TAB 2 --}}
            <div id="tersangka" class="tab-content space-y-2">

                {{-- NIK --}}
                <div>
                    <label class="block font-medium text-sm mb-1">
                        NIK <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nik" value="{{ old('nik') }}" required maxlength="16"
                        minlength="16" pattern="[0-9]{16}" class="w-full border border-gray-300 rounded-md p-2"
                        placeholder="Masukkan 16 digit NIK">
                </div>
                {{-- Nama Tersangka --}}
                <div>
                    <label class="block font-medium text-sm mb-1">Nama Lengkap Tersangka<span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nama_tersangka" value="{{ old('nama_tersangka') }}"
                        required class="w-full border border-gray-300 rounded-md p-2">
                </div>

                {{-- Foto Identitas Tersangka --}}
                <div>
                    <label class="block font-medium text-sm text-gray-800 mb-1">
                        Identitas Tersangka<span class="text-red-500">*</span>
                    </label>

                    <input type="file" name="file_identitas" accept=".pdf,.doc,.docx"
                        class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#022D57] focus:border-[#022D57]">

                    <p class="text-xs text-gray-500 mt-1">
                        Format file: <b>PDF, DOC, DOCX</b> • Maksimal ukuran: <b>2 MB</b> • KTP/SIM/Paspor
                    </p>

                    @error('file_identitas')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @php
                    $bb = old('barang_bukti', []);
                @endphp

                {{-- Barang Bukti Narkoba --}}
                <div>
                    <label class="block font-medium text-sm text-gray-800 mb-2">
                        Barang Bukti Narkoba<span class="text-red-500">*</span>
                    </label>

                    <div class="space-y-2">

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="barang_bukti[]" value="Sabu"
                                {{ in_array('Sabu', $bb) ? 'checked' : '' }}
                                class="w-4 h-4 text-[#022D57] border-gray-300 rounded">
                            <span class="text-sm text-gray-700">Sabu</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="barang_bukti[]" value="Ganja"
                                {{ in_array('Ganja', $bb) ? 'checked' : '' }}
                                class="w-4 h-4 text-[#022D57] border-gray-300 rounded">
                            <span class="text-sm text-gray-700">Ganja</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="barang_bukti[]" value="Ekstasi"
                                {{ in_array('Ekstasi', $bb) ? 'checked' : '' }}
                                class="w-4 h-4 text-[#022D57] border-gray-300 rounded">
                            <span class="text-sm text-gray-700">Ekstasi</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="barang_bukti[]" value="Heroin"
                                {{ in_array('Heroin', $bb) ? 'checked' : '' }}
                                class="w-4 h-4 text-[#022D57] border-gray-300 rounded">
                            <span class="text-sm text-gray-700">Heroin</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="barang_bukti[]" value="Kokain"
                                {{ in_array('Kokain', $bb) ? 'checked' : '' }}
                                class="w-4 h-4 text-[#022D57] border-gray-300 rounded">
                            <span class="text-sm text-gray-700">Kokain</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="barang_bukti[]" value="LSD"
                                {{ in_array('LSD', $bb) ? 'checked' : '' }}
                                class="w-4 h-4 text-[#022D57] border-gray-300 rounded">
                            <span class="text-sm text-gray-700">LSD</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="barang_bukti[]" value="Tembakau Gorila"
                                {{ in_array('Tembakau Gorila', $bb) ? 'checked' : '' }}
                                class="w-4 h-4 text-[#022D57] border-gray-300 rounded">
                            <span class="text-sm text-gray-700">
                                Tembakau Gorila (Sintetis)
                            </span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="barang_bukti[]" value="Lainnya"
                                {{ in_array('Lainnya', $bb) ? 'checked' : '' }}
                                class="w-4 h-4 text-[#022D57] border-gray-300 rounded">
                            <span class="text-sm text-gray-700 font-semibold">
                                Lainnya
                            </span>
                        </label>

                    </div>
                    @error('barang_bukti')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Berat Barang Bukti --}}
                <div>
                    <label class="block font-medium text-sm mb-1">Berat Barang Bukti (gram)<span
                            class="text-red-500">*</span></label>
                    <input type="text" name="berat_barang_bukti"
                        value="{{ old('berat_barang_bukti') }}" required
                        class="w-full border border-gray-300 rounded-md p-2">
                </div>

                {{-- Hasil Tes Urie --}}
                @php
                    $ur = old('hasil_urine', []);
                @endphp
                <div>
                    <label class="block font-medium text-sm text-gray-800 mb-2">
                        Hasil Tes Urine (pilih parameter yang positif)<span class="text-red-500">*</span>
                    </label>

                    <div class="space-y-2">

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hasil_urine[]" value="AMP"
                                {{ in_array('AMP', $ur) ? 'checked' : '' }}
                                class="w-4 h-4 text-[#022D57] border-gray-300 rounded">
                            <span class="text-sm text-gray-700">Amphetamine (AMP)</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hasil_urine[]" value="MET"
                                {{ in_array('MET', $ur) ? 'checked' : '' }}
                                class="w-4 h-4 text-[#022D57] border-gray-300 rounded">
                            <span class="text-sm text-gray-700">Methamphetamine (MET)</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hasil_urine[]" value="MOP"
                                {{ in_array('MOP', $ur) ? 'checked' : '' }}
                                class="w-4 h-4 text-[#022D57] border-gray-300 rounded">
                            <span class="text-sm text-gray-700">Morphine (MOP)</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hasil_urine[]" value="THC"
                                {{ in_array('THC', $ur) ? 'checked' : '' }}
                                class="w-4 h-4 text-[#022D57] border-gray-300 rounded">
                            <span class="text-sm text-gray-700">THC / Marijuana</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hasil_urine[]" value="COC"
                                {{ in_array('COC', $ur) ? 'checked' : '' }}
                                class="w-4 h-4 text-[#022D57] border-gray-300 rounded">
                            <span class="text-sm text-gray-700">Cocaine (COC)</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hasil_urine[]" value="BZO"
                                {{ in_array('BZO', $ur) ? 'checked' : '' }}
                                class="w-4 h-4 text-[#022D57] border-gray-300 rounded">
                            <span class="text-sm text-gray-700">Benzodiazepine (BZO)</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hasil_urine[]" value="SOMA"
                                {{ in_array('SOMA', $ur) ? 'checked' : '' }}
                                class="w-4 h-4 text-[#022D57] border-gray-300 rounded">
                            <span class="text-sm text-gray-700">Carisoprodol (SOMA)</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="hasil_urine[]" value="NEGATIF"
                                {{ in_array('NEGATIF', $ur) ? 'checked' : '' }}
                                class="w-4 h-4 text-[#022D57] border-gray-300 rounded">
                            <span class="text-sm text-gray-700 font-semibold">Semua Negatif</span>
                        </label>

                    </div>
                    @error('hasil_urine')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Konfirmasi --}}
                <div>
                    <label class="flex items-start gap-2 mt-2">
                        <input type="checkbox" name="konfirmasi" value="1"
                            {{ old('konfirmasi') ? 'checked' : '' }}
                            required class="w-4 h-4 text-[#022D57] border-gray-300 rounded mt-1">

                        <span class="text-sm text-gray-700 font-semibold">
                            Saya memahami bahwa data yang diisikan dalam formulir ini benar dan bertanggung jawab atas
                            hal tersebut
                        </span>
                    </label>
                </div>

                {{-- Submit --}}
                <div class="flex justify-end">
                    <button type="submit" class="bg-[#022D57] hover:bg-[#034077] text-white px-6 py-2 rounded-md">
                        Kirim
                    </button>
                </div>

            </div>

        </div>
    </form>
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

        tabButtons.forEach(button => {
            button.addEventListener('click', function () {

                const target = this.dataset.tab;

                // Reset semua tab button
                tabButtons.forEach(btn => {
                    btn.classList.remove('border-b-2', 'border-[#022D57]',
                        'text-[#022D57]');
                    btn.classList.add('text-gray-500');
                });

                // Aktifkan button yang diklik
                this.classList.add('border-b-2', 'border-[#022D57]', 'text-[#022D57]');
                this.classList.remove('text-gray-500');

                // Sembunyikan SEMUA tab content
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                    content.classList.remove('block'); // ← tambahan penting
                });

                // Tampilkan tab yang dipilih
                document.getElementById(target).classList.remove('hidden');
                document.getElementById(target).classList.add('block'); // ← tambahan penting
            });
        });

    });

</script>
@endsection
