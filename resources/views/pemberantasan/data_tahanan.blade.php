{{-- resources/views/pemberantasan/data_tahanan.blade.php --}}
@extends('layout.pemberantasan')
@section('title', 'Data Tahanan')

@section('content')

<div class="flex justify-center py-10">
    <div class="bg-white w-full max-w-6xl rounded-xl shadow-md border border-gray-200 p-6">

        {{-- Header --}}
        <div class="border-b border-gray-300 pb-3 mb-4 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-800">Data Tahanan</h2>
        </div>

        {{-- Search & Filter --}}
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4">

            {{-- Search --}}
            <label class="flex items-center gap-2 border rounded-lg px-3 py-2 w-full sm:w-64">
                <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" stroke="currentColor" fill="none" />
                    <path d="m21 21-4.3-4.3" stroke="currentColor" />
                </svg>
                <input type="search" id="searchInput" placeholder="Cari data..." class="outline-none text-sm w-full">
            </label>
            <button onclick="openModal('modalTambah')" class="btn btn-primary text-sm ml-3">
                <i class="fa-solid fa-plus mr-2"></i> Tambah
            </button>
        </div>

        <div class="overflow-x-auto">
            <table id="dataTable" class="table table-zebra w-full text-sm">
                <thead class="bg-gray-200 text-black">
                  <tr>
                        <th>No</th>
                        <th>Nomor Tahanan</th>
                        <th>Nama Tahanan</th>
                        <th>Dimulai Penahanan</th>
                        <th>Pasal yang Dilanggar</th>
                        <th>Warga Negara</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tahanan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nomor_tahanan }}</td>
                            <td>{{ $item->nama_tahanan }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') }}
                            </td>
                            <td>{{ $item->pasal_dilanggar }}</td>
                            <td>{{ $item->warga_negara }}</td>

                            <td class="flex gap-2">

                                {{-- DETAIL --}}
                                <button onclick="openModal('modalDetail{{ $item->id }}')"
                                    class="btn btn-sm btn-info text-white">
                                    <i class="fa-solid fa-circle-info"></i>
                                </button>

                                {{-- EDIT --}}
                                <button onclick="openModal('modalEdit{{ $item->id }}')"
                                    class="btn btn-sm btn-success text-white">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>

                                {{-- DELETE --}}
                                <button type="button" onclick="confirmDelete({{ $item->id }})"
                                    class="btn btn-sm btn-error text-white">
                                    <i class="fa-solid fa-trash"></i>
                                </button>

                                <form id="delete-form-{{ $item->id }}" method="POST"
                                    action="{{ route('admin.pemberantasan.data_tahanan.destroy', $item->id) }}"
                                    class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>

                        {{-- ================= MODAL EDIT ================= --}}
                        <div id="modalEdit{{ $item->id }}"
                            class="fixed inset-0 hidden z-[9999] bg-black/60 flex items-center justify-center">

                            <div
                                class="bg-white w-full max-w-5xl rounded-xl shadow-lg p-6 max-h-[90vh] overflow-y-auto">

                                <h3 class="font-bold text-xl text-gray-800 border-b pb-3 mb-5">
                                    Edit Data Tahanan
                                </h3>

                                <form method="POST"
                                    action="{{ route('pemberantasan.data_tahanan.update', $item->id) }}">
                                    @csrf
                                    @method('PUT')

                                    {{-- IDENTITAS TAHANAN --}}
                                    <div class="mb-6">
                                        <h4 class="font-semibold text-gray-700 mb-3">Identitas Tahanan</h4>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                            {{-- KIRI --}}
                                            <div class="space-y-4">

                                                <div>
                                                    <label class="font-medium">Nomor Tahanan</label>
                                                    <input type="text" name="nomor_tahanan"
                                                        class="input input-bordered w-full mt-1"
                                                        value="{{ $item->nomor_tahanan }}">
                                                </div>

                                                <div>
                                                    <label class="font-medium">Nama Tahanan</label>
                                                    <input type="text" name="nama_tahanan"
                                                        class="input input-bordered w-full mt-1"
                                                        value="{{ $item->nama_tahanan }}">
                                                </div>

                                                <div>
                                                    <label class="font-medium">Jenis Kelamin</label>
                                                    <select name="jenis_kelamin"
                                                        class="input input-bordered w-full mt-1">

                                                        <option value="Laki-laki"
                                                            {{ $item->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>
                                                            Laki-laki
                                                        </option>

                                                        <option value="Perempuan"
                                                            {{ $item->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                                                            Perempuan
                                                        </option>

                                                    </select>
                                                </div>

                                                <div>
                                                    <label class="font-medium">Dimulai Penahanan</label>
                                                    <input type="date" name="dimulai_penahanan"
                                                        class="input input-bordered w-full mt-1"
                                                        value="{{ $item->dimulai_penahanan }}">
                                                </div>

                                                <div>
                                                    <label class="font-medium">Pasal yang Dilanggar</label>
                                                    <input type="text" name="pasal_dilanggar"
                                                        class="input input-bordered w-full mt-1"
                                                        value="{{ $item->pasal_dilanggar }}">
                                                </div>

                                            </div>

                                            {{-- KANAN --}}
                                            <div class="space-y-4">

                                                <div>
                                                    <label class="font-medium">Tanggal Lahir</label>
                                                    <input type="date" name="tanggal_lahir"
                                                        class="input input-bordered w-full mt-1"
                                                        value="{{ $item->tanggal_lahir }}">
                                                </div>

                                                <div>
                                                    <label class="font-medium">Umur</label>
                                                    <input type="number" name="umur"
                                                        class="input input-bordered w-full mt-1"
                                                        value="{{ $item->umur }}">
                                                </div>

                                                <div>
                                                    <label class="font-medium">Warga Negara</label>
                                                    <input type="text" name="warga_negara"
                                                        class="input input-bordered w-full mt-1"
                                                        value="{{ $item->warga_negara }}">
                                                </div>

                                                <div>
                                                    <label class="font-medium">Pendidikan</label>
                                                    <input type="text" name="pendidikan"
                                                        class="input input-bordered w-full mt-1"
                                                        value="{{ $item->pendidikan }}">
                                                </div>

                                                <div>
                                                    <label class="font-medium">Pekerjaan</label>
                                                    <input type="text" name="pekerjaan"
                                                        class="input input-bordered w-full mt-1"
                                                        value="{{ $item->pekerjaan }}">
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    {{-- CIRI FISIK --}}
                                    <div class="mb-6">
                                        <h4 class="font-semibold text-gray-700 mb-3">Ciri Fisik</h4>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                            <div>
                                                <label class="font-medium">Tinggi Badan</label>
                                                <input type="number" name="tinggi_badan"
                                                    class="input input-bordered w-full mt-1"
                                                    value="{{ $item->tinggi_badan }}">
                                            </div>

                                            <div>
                                                <label class="font-medium">Berat Badan</label>
                                                <input type="number" name="berat_badan"
                                                    class="input input-bordered w-full mt-1"
                                                    value="{{ $item->berat_badan }}">
                                            </div>

                                            <div>
                                                <label class="font-medium">Warna Kulit</label>
                                                <input type="text" name="warna_kulit"
                                                    class="input input-bordered w-full mt-1"
                                                    value="{{ $item->warna_kulit }}">
                                            </div>

                                            <div>
                                                <label class="font-medium">Warna Mata</label>
                                                <input type="text" name="warna_mata"
                                                    class="input input-bordered w-full mt-1"
                                                    value="{{ $item->warna_mata }}">
                                            </div>

                                            <div>
                                                <label class="font-medium">Bentuk Muka</label>
                                                <input type="text" name="bentuk_muka"
                                                    class="input input-bordered w-full mt-1"
                                                    value="{{ $item->bentuk_muka }}">
                                            </div>

                                            <div>
                                                <label class="font-medium">Suku</label>
                                                <input type="text" name="suku" class="input input-bordered w-full mt-1"
                                                    value="{{ $item->suku }}">
                                            </div>

                                        </div>
                                    </div>

                                    {{-- BUTTON --}}
                                    <div class="flex justify-end gap-3 border-t pt-4">

                                        <button type="button" onclick="closeModal('modalEdit{{ $item->id }}')"
                                            class="btn bg-gray-200 hover:bg-gray-300 text-gray-700">
                                            Batal
                                        </button>

                                        <button class="btn btn-primary">
                                            Simpan
                                        </button>

                                    </div>

                                </form>
                            </div>
                        </div>

                        {{-- ================= MODAL DETAIL ================= --}}
                        <div id="modalDetail{{ $item->id }}"
                            class="fixed inset-0 hidden z-[9999] bg-black/60 flex items-center justify-center">

                            <div
                                class="bg-white w-full max-w-5xl rounded-xl shadow-lg p-6 max-h-[90vh] overflow-y-auto">

                                <h3 class="font-bold text-xl text-gray-800 border-b pb-3 mb-5">
                                    Detail Data Tahanan
                                </h3>

                                {{-- IDENTITAS TAHANAN --}}
                                <div class="mb-6">
                                    <h4 class="font-semibold text-gray-700 mb-3">Identitas Tahanan</h4>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                        {{-- KIRI --}}
                                        <div class="space-y-4">

                                            <div>
                                                <label class="font-medium">Nomor Tahanan</label>
                                                <div class="p-2 border rounded bg-gray-100">
                                                    {{ $item->nomor_tahanan }}
                                                </div>
                                            </div>

                                            <div>
                                                <label class="font-medium">Nama Tahanan</label>
                                                <div class="p-2 border rounded bg-gray-100">
                                                    {{ $item->nama_tahanan }}
                                                </div>
                                            </div>

                                            <div>
                                                <label class="font-medium">Jenis Kelamin</label>
                                                <div class="p-2 border rounded bg-gray-100">
                                                    {{ $item->jenis_kelamin }}
                                                </div>
                                            </div>

                                            <div>
                                                <label class="font-medium">Dimulai Penahanan</label>
                                                <div class="p-2 border rounded bg-gray-100">
                                                     {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') }}
                                                </div>
                                            </div>

                                            <div>
                                                <label class="font-medium">Pasal yang Dilanggar</label>
                                                <div class="p-2 border rounded bg-gray-100">
                                                    {{ $item->pasal_dilanggar }}
                                                </div>
                                            </div>

                                        </div>

                                        {{-- KANAN --}}
                                        <div class="space-y-4">

                                            <div>
                                                <label class="font-medium">Tanggal Lahir</label>
                                                <div class="p-2 border rounded bg-gray-100">
                                                    {{ $item->tanggal_lahir }}
                                                </div>
                                            </div>

                                            <div>
                                                <label class="font-medium">Umur</label>
                                                <div class="p-2 border rounded bg-gray-100">
                                                    {{ $item->umur }}
                                                </div>
                                            </div>

                                            <div>
                                                <label class="font-medium">Warga Negara</label>
                                                <div class="p-2 border rounded bg-gray-100">
                                                    {{ $item->warga_negara }}
                                                </div>
                                            </div>

                                            <div>
                                                <label class="font-medium">Pendidikan</label>
                                                <div class="p-2 border rounded bg-gray-100">
                                                    {{ $item->pendidikan }}
                                                </div>
                                            </div>

                                            <div>
                                                <label class="font-medium">Pekerjaan</label>
                                                <div class="p-2 border rounded bg-gray-100">
                                                    {{ $item->pekerjaan }}
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                {{-- CIRI FISIK --}}
                                <div class="mb-6">
                                    <h4 class="font-semibold text-gray-700 mb-3">Ciri Fisik</h4>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                        <div>
                                            <label class="font-medium">Tinggi Badan</label>
                                            <div class="p-2 border rounded bg-gray-100">
                                                {{ $item->tinggi_badan }}
                                            </div>
                                        </div>

                                        <div>
                                            <label class="font-medium">Berat Badan</label>
                                            <div class="p-2 border rounded bg-gray-100">
                                                {{ $item->berat_badan }}
                                            </div>
                                        </div>

                                        <div>
                                            <label class="font-medium">Warna Kulit</label>
                                            <div class="p-2 border rounded bg-gray-100">
                                                {{ $item->warna_kulit }}
                                            </div>
                                        </div>

                                        <div>
                                            <label class="font-medium">Warna Mata</label>
                                            <div class="p-2 border rounded bg-gray-100">
                                                {{ $item->warna_mata }}
                                            </div>
                                        </div>

                                        <div>
                                            <label class="font-medium">Bentuk Muka</label>
                                            <div class="p-2 border rounded bg-gray-100">
                                                {{ $item->bentuk_muka }}
                                            </div>
                                        </div>

                                        <div>
                                            <label class="font-medium">Suku</label>
                                            <div class="p-2 border rounded bg-gray-100">
                                                {{ $item->suku }}
                                            </div>
                                        </div>

                                        <div>
                                            <label class="font-medium">Author</label>
                                            <div class="p-2 border rounded bg-gray-100">
                                                {{ $item->user->name ?? '-' }}
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                {{-- BUTTON --}}
                                <div class="flex justify-end border-t pt-4">

                                    <button onclick="closeModal('modalDetail{{ $item->id }}')"
                                       class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                                        Tutup
                                    </button>

                                </div>

                            </div>
                        </div>

        </div>
    </div>
    @endforeach
    </tbody>
    </table>
</div>

        <div class="mt-6 overflow-hidden">
            {{ $tahanan->links('pagination::tailwind') }}
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div id="modalTambah" class="fixed inset-0 hidden z-[9999] bg-black/60 flex items-center justify-center">
   <div class="bg-white w-full max-w-5xl rounded-xl shadow-lg p-6 max-h-[90vh] overflow-y-auto">
        <h3 class="font-bold text-lg mb-4">Tambah Data Tahanan</h3>
        <form method="POST" action="{{ route('pemberantasan.data_tahanan.store') }}">
            @csrf

              {{-- DATA UTAMA --}}
            <div class="mb-6">
                <h4 class="font-semibold text-gray-700">Identitas Tahanan</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- KIRI --}}
                    <div class="space-y-4">

                        <div>
                            <label class="font-medium">Nomor Tahanan<span class="text-red-500">*</span></label>
                            <input type="text" name="nomor_tahanan" class="input input-bordered w-full mt-1" required>
                        </div>

                        <div>
                            <label class="font-medium">Nama Tahanan<span class="text-red-500">*</span></label>
                            <input type="text" name="nama_tahanan" class="input input-bordered w-full mt-1" required>
                        </div>

                        <div>
                            <label class="font-medium">Jenis Kelamin<span class="text-red-500">*</span></label>
                            <select name="jenis_kelamin" class="input input-bordered w-full mt-1" required>
                                <option value="">Pilih</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label class="font-medium">Dimulai Penahanan<span class="text-red-500">*</span></label>
                            <input type="date" name="dimulai_penahanan" class="input input-bordered w-full mt-1"
                                required>
                        </div>

                        <div>
                            <label class="font-medium">Pasal yang dilanggar<span class="text-red-500">*</span></label>
                            <input type="text" name="pasal_dilanggar" class="input input-bordered w-full mt-1" required>
                        </div>



                    </div>

                    {{-- KANAN --}}
                    <div class="space-y-4">

                        <div>
                            <label class="font-medium">Tanggal Lahir<span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_lahir" class="input input-bordered w-full mt-1" required>
                        </div>
                        <div>
                            <label class="font-medium">Umur<span class="text-red-500">*</span></label>
                            <input type="number" name="umur" class="input input-bordered w-full mt-1" required>
                        </div>

                        <div>
                            <label class="font-medium">Warga Negara<span class="text-red-500">*</span></label>
                            <input type="text" name="warga_negara" class="input input-bordered w-full mt-1" required>
                        </div>

                        <div>
                            <label class="font-medium">Pendidikan<span class="text-red-500">*</span></label>
                            <input type="text" name="pendidikan" class="input input-bordered w-full mt-1" required>
                        </div>

                        <div>
                            <label class="font-medium">Pekerjaan<span class="text-red-500">*</span></label>
                            <input type="text" name="pekerjaan" class="input input-bordered w-full mt-1" required>
                        </div>

                    </div>
                </div>
            </div>
            {{-- CIRI FISIK --}}
            <div class="mb-6">
                <h4 class="font-semibold text-gray-700">Ciri Fisik</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-medium">Tinggi Badan (cm)<span class="text-red-500">*</span></label>
                        <input type="number" name="tinggi_badan" class="input input-bordered w-full mt-1" required>
                    </div>

                    <div>
                        <label class="font-medium">Berat Badan (kg)<span class="text-red-500">*</span></label>
                        <input type="number" name="berat_badan" class="input input-bordered w-full mt-1" required>
                    </div>

                    <div>
                        <label class="font-medium">Warna Kulit<span class="text-red-500">*</span></label>
                        <input type="text" name="warna_kulit" class="input input-bordered w-full mt-1" required>
                    </div>

                    <div>
                        <label class="font-medium">Warna Mata<span class="text-red-500">*</span></label>
                        <input type="text" name="warna_mata" class="input input-bordered w-full mt-1" required>
                    </div>

                    <div>
                        <label class="font-medium">Bentuk Muka<span class="text-red-500">*</span></label>
                        <input type="text" name="bentuk_muka" class="input input-bordered w-full mt-1" required>
                    </div>

                    <div>
                        <label class="font-medium">Suku<span class="text-red-500">*</span></label>
                        <input type="text" name="suku" class="input input-bordered w-full mt-1" required>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                </div>
            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end gap-3 border-t pt-4">
                <button type="button" onclick="closeModal('modalTambah')"
                    class="btn bg-gray-200 hover:bg-gray-300 text-gray-700">
                    Batal
                </button>

                <button class="btn btn-primary">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // search
    const searchInput = document.getElementById('searchInput');
    const dataTable = document.getElementById('dataTable');
    const rows = dataTable.querySelectorAll('tbody tr');

    // Buat baris pesan "Data tidak tersedia"
    const emptyRow = document.createElement('tr');
    emptyRow.innerHTML = `
    <td colspan="8" class="text-center text-gray-500 py-4">
      Data tidak tersedia untuk pencarian ini.
    </td>
  `;
    emptyRow.style.display = 'none';
    dataTable.querySelector('tbody').appendChild(emptyRow);

    searchInput.addEventListener('keyup', function () {
        const keyword = this.value.toLowerCase();
        let visibleCount = 0;

        rows.forEach(row => {
            // skip modal rows (dialog) which are also in DOM; only check rows that have td
            const tds = row.querySelectorAll('td');
            if (tds.length === 0) return;

            let match = false;
            tds.forEach(cell => {
                if (cell.textContent.toLowerCase().includes(keyword)) match =
                    true;
            });

            row.style.display = match ? '' : 'none';
            if (match) visibleCount++;
        });

        emptyRow.style.display = visibleCount === 0 ? '' : 'none';
    });

</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- VALIDASI ERROR --}}
@if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Gagal menyimpan data, silakan cek kembali inputannya.',
        });

    </script>
@endif

{{-- SUCCESS TAMBAH / UPDATE --}}
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        });

    </script>
@endif

{{-- SUCCESS DELETE --}}
@if(session('deleted'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Terhapus!',
            text: '{{ session('deleted') }}',
            timer: 2000,
            showConfirmButton: false
        });

    </script>
@endif

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin hapus?',
            text: "Data tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

</script>

@endsection
