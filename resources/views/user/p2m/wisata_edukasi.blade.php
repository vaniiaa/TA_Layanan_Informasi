{{-- resources/views/user/p2m/wisata_edukasi.blade.php --}}
@extends('layout.user_bread')
@section('title', 'Permohonan Wisata Edukasi (DOEMBA)')

@section('content')
{{-- Dokumentasi Kegiatan --}}
<div class="w-full md:w-3/4 lg:w-3/4 mx-auto mt-[-50px] mb-10">
    {{-- Grid Foto --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">

        {{-- Foto 1 --}}
        <div class="group relative overflow-hidden rounded-xl shadow-lg">
            <img src="{{ asset('image/giat/p2m_doemba (5).jpg') }}"
                class="w-full h-52 object-cover transform group-hover:scale-110 transition duration-500">

            {{-- Overlay --}}
            <div
                class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                <p class="text-white text-sm font-semibold text-center px-3">
                    Wisata Edukasi DOEMBA/Dongeng Edukasi Mengenai Bahaya Narkoba
                </p>
            </div>
        </div>

        {{-- Foto 2 --}}
        <div class="group relative overflow-hidden rounded-xl shadow-lg">
            <img src="{{ asset('image/giat/p2m_doemba (2).jpg') }}"
                class="w-full h-52 object-cover transform group-hover:scale-110 transition duration-500">

            <div
                class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                <p class="text-white text-sm font-semibold text-center px-3">
                    Edukasi kepada pelajar terkait Mobil Incinerator Pemusnah Narkotika
                </p>
            </div>
        </div>

        {{-- Foto 3 --}}
        <div class="group relative overflow-hidden rounded-xl shadow-lg">
            <img src="{{ asset('image/giat/p2m_doemba (3).jpg') }}"
                class="w-full h-52 object-cover transform group-hover:scale-110 transition duration-500">

            <div
                class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                <p class="text-white text-sm font-semibold text-center px-3">
                    Edukasi kepada Pelajar terkait Unit K9 Anjing Pendeteksi Narkotika</p>
            </div>
        </div>

    </div>
</div>
<div class="container mx-auto px-4 pt-50 pb-12 relative">

    {{-- Card NOTE --}}
    <div class="bg-white rounded-xl shadow-md border border-[#022D57] p-6
            w-full md:w-3/4 lg:w-3/4 mx-auto mt-[-200px]">
        <h2 class="text-lg font-bold text-black mb-3">NOTE!!</h2>
        <p class="text-gray-700 text-sm leading-relaxed space-y-2">
            Salam sehat tanpa narkoba!
        </p>
        <p class="text-gray-700 text-sm leading-relaxed space-y-2">Berikut adalah formulir permohonan kunjungan wisata
            edukasi di BNN Provinsi Kepri dan Loka Rehabilitasi BNN Batam, terdapat
            beberapa hal yang harus diperhatikan:</p>
        <ul class="list-decimal list-inside text-sm text-gray-700 mt-2 space-y-1">
            <li>Maksimal peserta kunjungan sebanyak 30 (tiga puluh) orang per kunjungan.</li>
            <li>Kegiatan akan dilaksanakan selama 2 jam (20 menit)</li>
            <li>Pengajuan surat permohonan dikirimkan minimal 1 (satu) minggu setelah pelaksanaan kegiatan.</li>
            <li>Mengisi formulir permohonan berikut.</li>
            <li>Layanan wisata edukasi tidak dipungut biaya atau GRATIS.</li>
        </ul>
        <p class="text-gray-700 text-sm mt-3">
            Demikian informasi yang dapat kami sampaikan. Terima kasih!
        </p>
        <p class="font-semibold text-gray-800 mt-2">WAR ON DRUGS</p>
    </div>

    {{-- Card Form --}}
    <div class="bg-white rounded-xl shadow-md border border-[#022D57] p-8 mt-5 
            w-full md:w-3/4 lg:w-3/4 mx-auto">
        <h2 class="text-xl font-bold text-black mb-6">Data Permohonan</h2>

        <form action="{{ route('wisata_edukasi.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-5">
            @csrf

            {{-- Nama Lengkap --}}
            <div>
                <label class="block font-medium text-sm text-gray-800 mb-1">Nama Lengkap PIC<span
                        class="text-red-500">*</span></label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                    class="w-full border border-gray-300 rounded-md p-2">
            </div>

            {{-- No Telp --}}
            <div>
                <label class="block font-medium text-sm text-gray-800 mb-1">No Telp PIC<span
                        class="text-red-500">*</span></label>
                <input type="text" name="no_telp" value="{{ old('no_telp') }}" required
                    class="w-full border border-gray-300 rounded-md p-2">
            </div>
          {{-- Nama Sekolah --}}
<div>
    <label class="block font-medium text-sm text-gray-800 mb-1">
        Nama Sekolah<span class="text-red-500">*</span>
    </label>

    <select id="data_sekolah_id" name="data_sekolah_id" required
        class="w-full border border-gray-300 rounded-md p-2">

        <option value="">-- Pilih Sekolah --</option>

        @foreach($sekolah as $item)
            <option value="{{ $item->id }}"
                {{ old('data_sekolah_id') == $item->id ? 'selected' : '' }}>
                {{ $item->nama_sekolah }}
            </option>
        @endforeach

    </select>
</div>
            <div>
                <label class="block font-medium text-sm text-gray-800 mb-1">
                    NPSN
                </label>
                <input type="text" id="npsn" readonly class="w-full border border-gray-300 rounded-md p-2 bg-gray-100">
            </div>
            {{-- Alamat --}}
            <div>
                <label class="block font-medium text-sm text-gray-800 mb-1">Alamat<span
                        class="text-red-500">*</span></label>
                <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}" readonly
                    class="w-full border border-gray-300 rounded-md p-2 bg-gray-100 mb-4">


                {{-- Tanggal & Waktu --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-sm text-gray-800 mb-1">Tanggal Kegiatan<span
                                class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_kegiatan"
                            value="{{ old('tanggal_kegiatan') }}" required
                            class="w-full border border-gray-300 rounded-md p-2 mb-4">
                    </div>
                    <div>
                        <label class="block font-medium text-sm text-gray-800 mb-1">Waktu Kegiatan<span
                                class="text-red-500">*</span></label>
                        <input type="time" name="waktu_kegiatan" value="{{ old('waktu_kegiatan') }}"
                            required class="w-full border border-gray-300 rounded-md p-2">
                    </div>
                </div>

                {{-- Jumlah Peserta --}}
                <div>
                    <label class="block font-medium text-sm text-gray-800 mb-1">
                        Jumlah Peserta (Maks: 30 peserta/kunjungan)<span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="jumlah_peserta" value="{{ old('jumlah_peserta') }}"
                        max="30" min="1" required oninput="if(this.value > 30) this.value = 30;"
                        class="w-full border border-gray-300 rounded-md p-2 mb-4">
                </div>

                {{-- Surat Permohonan --}}
                <div>
                    <label class="block font-medium text-sm text-gray-800 mb-1">
                        Surat Permohonan<span class="text-red-500">*</span>
                    </label>

                    <input type="file" name="surat_permohonan" accept=".pdf,.doc,.docx"
                        class="w-full border border-gray-300 rounded-md p-2">

                    <p class="text-xs text-gray-500 mt-1 mb-4">
                        Format file: <b>PDF, DOC, DOCX</b> • Maksimal ukuran: <b>2 MB</b>
                    </p>

                    @error('surat_permohonan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi --}}
                <div>
                    <label class="flex items-center gap-2 mt-2">
                        <input type="checkbox" name="konfirmasi"
                            value="Saya memahami bahwa data yang diisikan benar dan bertanggung jawab"
                            {{ old('konfirmasi') == '   Saya memahami bahwa data yang diisikan benar dan bertanggung jawab' ? 'checked' : '' }}
                            required>

                        <span class="text-sm text-gray-800">
                            Saya memahami bahwa data yang diisikan benar dan bertanggung jawab
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
        </form>
    </div>
</div>
{{-- Tom Select CSS --}}
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">

{{-- Tom Select JS --}}
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

<script>
    new TomSelect("#data_sekolah_id",{
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        },
        placeholder: "Cari nama sekolah..."
    });
</script>
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
    document.getElementById('data_sekolah_id').addEventListener('change', function () {
        let sekolahId = this.value;

        if (sekolahId) {
            fetch(`/get-sekolah/${sekolahId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('npsn').value = data.npsn;
                    document.getElementById('alamat').value = data.alamat;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        } else {
            document.getElementById('npsn').value = '';
            document.getElementById('alamat').value = '';
        }
    });

</script>
@endsection
