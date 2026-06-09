{{-- resources/views/user/pemberantasan/besuk_tahanan.blade.php --}}
@extends('layout.user_bread')
@section('title', 'Pendaftaran Besuk Tahanan')

@section('content')
{{-- Dokumentasi Kegiatan --}}
<div class="w-full md:w-3/4 lg:w-3/4 mx-auto mt-[-50px] mb-10">
    {{-- Grid Foto --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">

        {{-- Foto 1 --}}
        <div class="group relative overflow-hidden rounded-xl shadow-lg">
            <img src="{{ asset('image/giat/pemberantasan_besuk (1).jpeg') }}"
                class="w-full h-52 object-cover transform group-hover:scale-110 transition duration-500">

            {{-- Overlay --}}
            <div
                class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                <p class="text-white text-sm font-semibold text-center px-3">
                    Proses Besuk Tahanan
                </p>
            </div>
        </div>

        {{-- Foto 2 --}}
        <div class="group relative overflow-hidden rounded-xl shadow-lg">
            <img src="{{ asset('image/giat/pemberantasan_besuk (2).jpeg') }}"
                class="w-full h-52 object-cover transform group-hover:scale-110 transition duration-500">

            <div
                class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                <p class="text-white text-sm font-semibold text-center px-3">
                    Proses Besuk Tahanan
                </p>
            </div>
        </div>

        {{-- Foto 3 --}}
        <div class="group relative overflow-hidden rounded-xl shadow-lg">
            <img src="{{ asset('image/giat/pemberantasan_besuk (3).jpeg') }}"
                class="w-full h-52 object-cover transform group-hover:scale-110 transition duration-500">

            <div
                class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                <p class="text-white text-sm font-semibold text-center px-3">
                    Proses Besuk Tahanan</p>
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
        <p class="text-gray-700 text-sm leading-relaxed space-y-2">Selamat Datang di Rutan BNNP Kepulauan Riau. Sebelum
            Anda melakukan kunjungan terhadap Tahanan kami, silakan untuk mengisi form yang ada berikut ini sebagai
            bentuk upaya mitigasi risiko pengawasan tahanan. Form pendaftaran ini mengacu pada SOP besuk tahanan yang
            ada di Seksi Wastahti dan diharapkan dapat menjadi database dalam digitalisasi tahanan BNNP Kepulauan Riau.
        </p>
        <p class="text-gray-700 text-sm mt-3">
            Demikian informasi yang dapat kami sampaikan. Terima kasih!
        </p>
        <p class="font-semibold text-gray-800 mt-2">WAR ON DRUGS</p>
    </div>


    {{-- CARD CEK NOMOR TAHANAN --}}
    <div class="bg-white rounded-xl shadow-md border  border-[#022D57] p-6
            w-full md:w-3/4 lg:w-3/4 mx-auto mt-6">

        <h3 class="text-lg font-bold mb-4 text-gray-800">
            Cek Data Tahanan
        </h3>

        <div class="flex flex-col sm:flex-row gap-3">
            <input type="text" id="nomorTahanan" placeholder="Masukkan nomor tahanan"
                class="input input-bordered w-full">

            <button onclick="cekTahanan()" class="btn btn-primary sm:w-auto">
                Cari
            </button>
        </div>

        {{-- HASIL DATA --}}
        <div id="hasilTahanan" class="mt-4 hidden">
            <div class="bg-blue-50 border border-blue-300 rounded-lg p-4 text-sm space-y-3">

                {{-- Nama Tahanan --}}
                <div>
                    <label class="font-semibold text-gray-700">
                        Nama Tahanan
                    </label>

                    <input type="text" id="namaTahanan" class="input input-bordered w-full mt-1 bg-white" readonly>
                </div>

                {{-- Nomor Tahanan --}}
                <div>
                    <label class="font-semibold text-gray-700">
                        Nomor Tahanan
                    </label>

                    <input type="text" id="nomorTahananHasil" class="input input-bordered w-full mt-1 bg-white"
                        readonly>
                </div>

                {{-- Warga Negara --}}
                <div>
                    <label class="font-semibold text-gray-700">
                        Warga Negara
                    </label>

                    <input type="text" id="wargaNegara" class="input input-bordered w-full mt-1 bg-white" readonly>
                </div>

            </div>
        </div>

        {{-- TIDAK DITEMUKAN --}}
        <div id="notFound" class="mt-4 hidden text-red-600 font-medium text-sm">
            Nomor tahanan tidak ditemukan
        </div>

    </div>

    <form action="{{ route('besuk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- ===================== CARD 1 ===================== --}}
        <div id="cardPendaftaran" class="hidden">

            <div class="bg-white rounded-xl shadow-md border border-[#022D57] p-8 mt-5
        w-full md:w-3/4 lg:w-3/4 mx-auto">

                <h2 class="text-xl font-bold text-[#022D57] mb-4">
                    Data Permohonan
                </h2>

                <form action="{{ route('besuk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Hidden ID Tahanan --}}
                    <input type="hidden" name="tahanan_id" id="tahanan_id">

                    {{-- TAB NAVIGATION --}}
                    <div class="border-b border-gray-200 mb-6">
                        <div class="flex flex-wrap">

                            <button type="button"
                                class="tab-btn px-6 py-3 border-b-2 border-[#022D57] text-[#022D57] font-medium"
                                data-tab="permohonan">
                                Data Kunjungan
                            </button>

                            <button type="button" class="tab-btn px-6 py-3 text-gray-500 font-medium"
                                data-tab="pembesuk">
                                Data Pembesuk
                            </button>

                        </div>
                    </div>

                    {{-- ================= TAB DATA PERMOHONAN ================= --}}
                    <div id="permohonan" class="tab-content block space-y-4">

                        <div>
                            <label class="block font-medium text-sm text-gray-800 mb-1">
                                Hari Kunjungan
                                <span class="text-red-500">*</span>
                            </label>

                            <select name="hari_kunjungan" required
                                class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#022D57] focus:border-[#022D57]">

                                <option value="">-- Pilih Hari --</option>

                                <option value="Selasa"
                                    {{ old('hari_kunjungan') == 'Selasa' ? 'selected' : '' }}>
                                    Selasa
                                </option>

                                <option value="Kamis"
                                    {{ old('hari_kunjungan') == 'Kamis' ? 'selected' : '' }}>
                                    Kamis
                                </option>

                            </select>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-800 mb-1">
                                Tanggal Kedatangan
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="date" name="tanggal_kedatangan"
                                value="{{ old('tanggal_kedatangan') }}" required
                                class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#022D57] focus:border-[#022D57]">
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-800 mb-1">
                                Jam Masuk
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="time" name="jam_masuk" value="{{ old('jam_masuk') }}"
                                required
                                class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#022D57] focus:border-[#022D57]">
                        </div>

                    </div>

                    {{-- ================= TAB DATA PEMBESUK ================= --}}
                    <div id="pembesuk" class="tab-content hidden space-y-4">

                        <div>
                            <label class="block font-medium text-sm text-gray-800 mb-2">
                                Self Assessment Kesehatan Pembesuk
                                <span class="text-red-500">*</span>
                            </label>

                            <div class="space-y-2">

                                <label class="flex items-center gap-2">
                                    <input type="radio" name="self_assessment" value="Sehat" required
                                        {{ old('self_assessment') == 'Sehat' ? 'checked' : '' }}>

                                    <span>Sehat</span>
                                </label>

                                <label class="flex items-center gap-2">
                                    <input type="radio" name="self_assessment" value="Tidak Sehat"
                                        {{ old('self_assessment') == 'Tidak Sehat' ? 'checked' : '' }}>

                                    <span>Tidak Sehat</span>
                                </label>

                            </div>
                        </div>

                        {{-- Nama Pembesuk --}}
                        <div>
                            <label class="block font-medium text-sm text-gray-800 mb-1">
                                Nama Lengkap Pembesuk
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" name="nama_pembesuk" value="{{ old('nama_pembesuk') }}"
                                required
                                class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#022D57] focus:border-[#022D57]">
                        </div>

                        {{-- Alamat --}}
                        <div>
                            <label class="block font-medium text-sm text-gray-800 mb-1">
                                Alamat Pembesuk
                                <span class="text-red-500">*</span>
                            </label>

                            <textarea name="alamat_pembesuk" rows="3" required
                                class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#022D57] focus:border-[#022D57]">{{ old('alamat_pembesuk') }}</textarea>
                        </div>

                        {{-- Nomor HP --}}
                        <div>
                            <label class="block font-medium text-sm text-gray-800 mb-1">
                                No HP (WA)
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" required
                                class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#022D57] focus:border-[#022D57]">
                        </div>

                        {{-- Hubungan --}}
                        <div>
                            <label class="block font-medium text-sm text-gray-800 mb-1">
                                Hubungan
                                <span class="text-red-500">*</span>
                            </label>

                            <select name="hubungan" required
                                class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#022D57] focus:border-[#022D57]">

                                <option value="">-- Pilih Hubungan --</option>

                                <option value="Orang Tua"
                                    {{ old('hubungan') == 'Orang Tua' ? 'selected' : '' }}>
                                    Orang Tua
                                </option>

                                <option value="Pasangan"
                                    {{ old('hubungan') == 'Pasangan' ? 'selected' : '' }}>
                                    Pasangan
                                </option>

                                <option value="Saudara"
                                    {{ old('hubungan') == 'Saudara' ? 'selected' : '' }}>
                                    Saudara
                                </option>

                                <option value="Kerabat"
                                    {{ old('hubungan') == 'Kerabat' ? 'selected' : '' }}>
                                    Kerabat
                                </option>

                                <option value="Lainnya"
                                    {{ old('hubungan') == 'Lainnya' ? 'selected' : '' }}>
                                    Lainnya
                                </option>

                            </select>
                        </div>

                        {{-- Upload Identitas --}}
                        <div>
                            <label class="block font-medium text-sm text-gray-800 mb-1">
                                Foto KTP / SIM / PASPOR
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="file" name="foto_identitas"
                                class="w-full border border-gray-300 rounded-md p-2">

                            <p class="text-xs text-gray-500 mt-1">
                                Format: <b>JPG, JPEG, PNG</b> • Maksimal: <b>2 MB</b>
                            </p>

                            @error('foto_identitas')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Barang Bawaan --}}
                        <div>
                            <label class="block font-medium text-sm text-gray-800 mb-2">
                                Barang yang Dibawa untuk Tahanan
                                <span class="text-red-500">*</span>
                            </label>

                            <div class="space-y-2">

                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="barang[]" value="Makanan">
                                    <span>Makanan</span>
                                </label>

                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="barang[]" value="Pakaian">
                                    <span>Pakaian</span>
                                </label>

                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="barang[]" value="Obat">
                                    <span>Obat</span>
                                </label>

                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="barang[]" value="Lainnya">
                                    <span>Lainnya</span>
                                </label>

                            </div>

                            @error('barang')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Submit --}}
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
        {{-- SCRIPT CEK TAHANAN --}}
        <script>
            function cekTahanan() {

                let nomor = document.getElementById('nomorTahanan').value;

                fetch(`/cek-nomor-tahanan?nomor_tahanan=${nomor}`)
                    .then(response => response.json())
                    .then(data => {

                        // jika data ditemukan
                        if (data && data.id) {

                            // tampilkan hasil
                            document.getElementById('hasilTahanan').classList.remove('hidden');

                            // tampilkan form pendaftaran
                            document.getElementById('cardPendaftaran').classList.remove('hidden');

                            // sembunyikan notif
                            document.getElementById('notFound').classList.add('hidden');

                            // isi data
                            document.getElementById('namaTahanan').value = data.nama_tahanan;
                            document.getElementById('nomorTahananHasil').value = data.nomor_tahanan;
                            document.getElementById('wargaNegara').value = data.warga_negara;

                            // kirim tahanan_id ke database
                            document.getElementById('tahanan_id').value = data.id;

                        } else {

                            // sembunyikan hasil
                            document.getElementById('hasilTahanan').classList.add('hidden');

                            // sembunyikan form
                            document.getElementById('cardPendaftaran').classList.add('hidden');

                            // tampilkan notif
                            document.getElementById('notFound').classList.remove('hidden');
                        }

                    })
                    .catch(error => {

                        console.log(error);

                        // sembunyikan hasil
                        document.getElementById('hasilTahanan').classList.add('hidden');

                        // sembunyikan form
                        document.getElementById('cardPendaftaran').classList.add('hidden');

                        // tampilkan notif
                        document.getElementById('notFound').classList.remove('hidden');
                    });
            }

        </script>
        {{-- Library --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function () { // memastikan script jalan setelah halaman selesai load

                // live search input tahanan
                $('#tahanan_input').on('keyup', function () {

                    let query = $(this).val(); //ambil nilaiinput yg diketik user

                    // haya jalan jikaminimal 1 huurf
                    if (query.length >= 1) {

                        $.ajax({
                            url: "{{ route('user.tahanan.search') }}", //route laravel untuk search data tahanan
                            type: "GET",
                            data: {
                                q: query // kirim keyword ke backend
                            },

                            success: function (data) {

                                let html = '';

                                // jika data ditemukan
                                if (data.length > 0) {

                                    data.forEach(function (item) {

                                        html += `
                                <div class="p-2 cursor-pointer hover:bg-gray-100"
                                     data-id="${item.id}"
                                     data-nama="${item.nama_tahanan}">
                                     
                                     ${item.nomor_tahanan} - ${item.nama_tahanan}

                                </div>
                            `;

                                    });

                                    $('#tahanan_list')
                                        .html(html) //masukkan hasil ke dropdown
                                        .show(); //tampilkan dropdown

                                } else {
                                    //jika tidak ada data                
                                    $('#tahanan_list').html(`
                            <div class="p-2 text-gray-500">
                                Tidak ditemukan
                            </div>
                        `).show();

                                }

                            }
                        });

                    } else {
                        //jika input kosong, sembunyikan dropdown
                        $('#tahanan_list').hide();

                    }

                });


                // Ketika user klik salah satu hasil
                $(document).on('click', '#tahanan_list div', function () {

                    let nama = $(this).data('nama'); //ambil nama dari data-attribute
                    let id = $(this).data('id'); //ambil id dari data-attribute

                    $('#tahanan_input').val(nama); // isi input dgn nama tahanan
                    $('#tahanan_id').val(id); // simpan id di hidden input

                    $('#tahanan_list').hide(); // sembunyikan dropdown

                });


                // Jika klik di luar list
                $(document).click(function (e) {

                    if (!$(e.target).closest('#tahanan_input, #tahanan_list')
                        .length) { //jika klik bukan diinput/list

                        $('#tahanan_list').hide(); //sembunyikan dropdown

                    }

                });

            });

        </script>

        @if($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Gagal menambahkan data, silahkan cek kembali inputannya.',
                });

            </script>
        @endif
</div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const tabButtons = document.querySelectorAll('.tab-btn');

        const permohonan = document.getElementById('permohonan');
        const pembesuk = document.getElementById('pembesuk');

        tabButtons.forEach(button => {

            button.addEventListener('click', function () {

                const target = this.dataset.tab;

                tabButtons.forEach(btn => {

                    btn.classList.remove(
                        'border-b-2',
                        'border-[#022D57]',
                        'text-[#022D57]'
                    );

                    btn.classList.add('text-gray-500');
                });

                this.classList.add(
                    'border-b-2',
                    'border-[#022D57]',
                    'text-[#022D57]'
                );

                this.classList.remove('text-gray-500');

                if (target === 'permohonan') {

                    permohonan.style.display = 'block';
                    pembesuk.style.display = 'none';

                } else {

                    permohonan.style.display = 'none';
                    pembesuk.style.display = 'block';

                }

            });

        });

    });

</script>
@endsection
