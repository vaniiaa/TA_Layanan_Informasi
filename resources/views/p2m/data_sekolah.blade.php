{{-- resources/views/p2m/data_sekolah.blade.php --}}
@extends('layout.p2m')
@section('title', 'Data Sekolah')

@section('content')

<div class="flex justify-center py-10">
    <div class="bg-white w-full max-w-6xl rounded-xl shadow-md border border-gray-200 p-6">

        {{-- Header --}}
        <div class="border-b border-gray-300 pb-3 mb-4 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-800">Data Sekolah</h2>
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
                        <th>NPSN</th>
                        <th>Nama Sekolah</th>
                        <th>Alamat</th>
                        <th>Status Sekolah</th>
                        <th>Bentuk Pendidikan</th>
                        <th>Authors</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->npsn }}</td>
                            <td>{{ $item->nama_sekolah }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->status_sekolah }}</td>
                            <td>{{ $item->bentuk_pendidikan }}</td>
                            <td>
                                {{ $item->user->name ?? '-' }}
                            </td>
                            <td class="flex gap-2">
                                <button onclick="openModal('modalEdit{{ $item->id }}')"
                                    class="btn btn-sm btn-success text-white">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                                <button type="button" onclick="confirmDelete({{ $item->id }})"
                                    class="btn btn-sm btn-error text-white">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $item->id }}" method="POST"
                                    action="{{ route('p2m.data_sekolah.delete', $item->id) }}"
                                    class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>

                        {{-- ================= MODAL EDIT ================= --}}
                        <div id="modalEdit{{ $item->id }}"
                            class="fixed inset-0 hidden z-[9999] bg-black/60 flex items-center justify-center">
                            <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6">
                                <h3 class="font-bold text-lg mb-4">Edit Sekolah</h3>
                                <form method="POST"
                                    action="{{ route('p2m.data_sekolah.update', $item->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="font-semibold">NPSN</label>
                                        <input type="text" name="npsn" value="{{ $item->npsn }}"
                                            class="input input-bordered w-full" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="font-semibold">Nama Sekolah</label>
                                        <input type="text" name="nama_sekolah" value="{{ $item->nama_sekolah }}"
                                            class="input input-bordered w-full" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="font-semibold">Alamat</label>
                                        <textarea name="alamat" class="input input-bordered w-full"
                                            required>{{ $item->alamat }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="font-semibold">Status Sekolah</label>
                                        <select name="status_sekolah" class="select select-bordered w-full" required>
                                            <option value="negeri"
                                                {{ $item->status_sekolah == 'negeri' ? 'selected' : '' }}>
                                                Negeri</option>
                                            <option value="swasta"
                                                {{ $item->status_sekolah == 'swasta' ? 'selected' : '' }}>
                                                Swasta</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="font-semibold">Bentuk Pendidikan</label>
                                        <select name="bentuk_pendidikan" class="select select-bordered w-full" required>
                                            <option value="SMA"
                                                {{ $item->bentuk_pendidikan == 'SMA' ? 'selected' : '' }}>
                                                SMA</option>
                                            <option value="SMK"
                                                {{ $item->bentuk_pendidikan == 'SMK' ? 'selected' : '' }}>
                                                SMK</option>
                                        </select>
                                    </div>

                                    <div class="flex justify-end gap-2">
                                        <button type="button" onclick="closeModal('modalEdit{{ $item->id }}')"
                                            class="btn">Batal</button>
                                        <button class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 overflow-hidden">
            {{ $data->links('pagination::tailwind') }}
        </div>
    </div>
</div>

{{-- ================= MODAL TAMBAH ================= --}}
<div id="modalTambah" class="fixed inset-0 hidden z-[9999] bg-black/60 flex items-center justify-center">
    <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6">
        <h3 class="font-bold text-lg mb-4">Tambah Sekolah</h3>
        <form method="POST" action="{{ route('p2m.data_sekolah.store') }}">
            @csrf
            <div class="mb-3">
                <label class="font-semibold">NPSN<span class="text-red-500">*</span></label>
                <input type="text" name="npsn" class="input input-bordered w-full" required>
            </div>

            <div class="mb-3">
                <label class="font-semibold">Nama Sekolah<span class="text-red-500">*</span></label>
                <input type="text" name="nama_sekolah" class="input input-bordered w-full" required>
            </div>

            <div class="mb-3">
                <label class="font-semibold">Alamat<span class="text-red-500">*</span></label>
                <textarea name="alamat" class="input input-bordered w-full" required></textarea>
            </div>

            <div class="mb-3">
                <label class="font-semibold">Status Sekolah<span class="text-red-500">*</span></label>
                <select name="status_sekolah" class="select select-bordered w-full" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="negeri">Negeri</option>
                    <option value="swasta">Swasta</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="font-semibold">Bentuk Pendidikan<span class="text-red-500">*</span></label>
                <select name="bentuk_pendidikan" class="select select-bordered w-full" required>
                    <option value="">-- Pilih Bentuk Pendidikan --</option>
                    <option value="SMA">SMA</option>
                    <option value="SMK">SMK</option>
                </select>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('modalTambah')" class="btn">Batal</button>
                <button class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
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

@endsection
