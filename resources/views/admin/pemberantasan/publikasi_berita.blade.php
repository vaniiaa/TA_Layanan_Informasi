{{-- resources/views/admin/pemberantasan/publikasi_berita.blade.php --}}
@extends('layout.admin')

@section('title', 'Dashboard')

@section('content')
<div class="flex justify-center py-10">
    <div class="bg-white w-full max-w-6xl rounded-xl shadow-md border border-gray-200 p-6">

        {{-- HEADER --}}
        <div class="border-b border-gray-300 pb-3 mb-4 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-800">Publikasi Berita</h2>
        </div>

        {{-- SEARCH + TAMBAH --}}
        <div class="flex items-center justify-between w-full mb-4">
            <label class="flex items-center gap-2 border rounded-lg px-3 py-2 w-full sm:w-64">
                <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" stroke="currentColor" fill="none" />
                    <path d="m21 21-4.3-4.3" stroke="currentColor" />
                </svg>
                <input type="search" id="searchInput" placeholder="Cari data..." class="outline-none text-sm w-full">
            </label>

            <button onclick="openModal('modalTambah')" class="btn btn-primary">
                <i class="fa-solid fa-plus mr-2"></i> Tambah
            </button>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table id="dataTable" class="table table-zebra w-full text-sm">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th>No</th>
                        <th>Jenis</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Authors</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($publikasi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ ucfirst($item->jenis) }}</td>
                            <td>{{ $item->judul }}</td>
                            <td>{{ Str::limit($item->deskripsi, 40) }}</td>
                            <td>{{ $item->user->name ?? '-' }}</td>
                            <td class="flex gap-2">
                                <button onclick="openModal('modalDetail{{ $item->id }}')"
                                    class="btn btn-sm btn-info text-white">
                                    <i class="fa-solid fa-circle-info"></i>
                                </button>

                                <button onclick="openModal('modalEdit{{ $item->id }}')"
                                    class="btn btn-sm btn-success text-white">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>

                                <button type="button" onclick="confirmDelete({{ $item->id }})"
                                    class="btn btn-sm btn-error text-white">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $item->id }}" method="POST"
                                    action="{{ route('admin.publikasi.destroy', $item->id) }}"
                                    class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        {{-- ================= MODAL DETAIL ================= --}}
                        <div id="modalDetail{{ $item->id }}"
                            class="fixed inset-0 hidden z-[9999] bg-black/60 flex items-center justify-center">

                            <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6 max-h-[90vh] overflow-y-auto">

                                <h3 class="font-bold text-lg border-b pb-2 mb-4">
                                    Detail Publikasi Berita
                                </h3>

                                <div class="space-y-4 text-sm">
                                    <div>
                                        <label class="font-semibold">Judul</label>
                                        <input class="w-full border rounded-lg p-2 bg-gray-100"
                                            value="{{ $item->judul }}" readonly>
                                    </div>

                                    <div>
                                        <label class="font-semibold">Deskripsi</label>
                                        <textarea class="w-full border rounded-lg p-2 bg-gray-100"
                                            readonly>{{ $item->deskripsi }}</textarea>
                                    </div>

                                    <div>
                                        <label class="font-semibold">Gambar</label>
                                        <div class="flex gap-3">
                                            <input class="flex-1 border rounded-lg p-2 bg-gray-100"
                                                value="{{ $item->gambar }}" readonly>
                                            <a href="{{ asset('storage/'.$item->gambar) }}"
                                                target="_blank" class="bg-sky-500 text-white px-3 py-2 rounded-md">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="font-semibold">Tanggal Upload</label>
                                        <input class="w-full border rounded-lg p-2 bg-gray-100"
                                            value="{{ $item->created_at->format('d M Y') }}"
                                            readonly>
                                    </div>
                                </div>

                                <div class="text-right mt-6">
                                    <button onclick="closeModal('modalDetail{{ $item->id }}')"
                                        class="bg-red-600 text-white px-4 py-2 rounded-lg">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>


                        {{-- ================= MODAL EDIT ================= --}}
                        <div id="modalEdit{{ $item->id }}"
                            class="fixed inset-0 hidden z-[9999] bg-black/60 flex items-center justify-center">

                            <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6 max-h-[90vh] overflow-y-auto">
                                <h3 class="font-bold text-lg mb-4">Edit Publikasi</h3>

                                <form method="POST"
                                    action="{{ route('admin.publikasi.update', $item->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label class="font-semibold">Judul</label>
                                        <input type="text" name="judul" class="input input-bordered w-full"
                                            value="{{ $item->judul }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="font-semibold">Deskripsi</label>
                                        <textarea name="deskripsi" class="textarea textarea-bordered w-full"
                                            required>{{ $item->deskripsi }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="font-semibold">Gambar</label>
                                        <input type="file" name="gambar" class="file-input w-full">
                                    </div>

                                    <div class="flex justify-end gap-2">

                                        <button type="button" onclick="closeModal('modalEdit{{ $item->id }}')"
                                            class="btn">
                                            Batal
                                        </button>
                                        <button class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
        </div>
    </div>
</div>
@endforeach
</tbody>
{{-- ================= MODAL TAMBAH ================= --}}
<div id="modalTambah" class="fixed inset-0 hidden z-[9999] bg-black/60 flex items-center justify-center">

    <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6 max-h-[90vh] overflow-y-auto">

        <h3 class="font-bold text-lg mb-4">Tambah Publikasi</h3>

        <form action="{{ route('admin.publikasi.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="font-semibold">Jenis<span class="text-red-500">*</span></label>
                <select id="jenis" name="jenis" class="select select-bordered w-full" required>
                    <option value="">-- Pilih --</option>
                    <option value="berita">Berita</option>
                    <option value="infografis">Infografis</option>
                </select>
            </div>

            <div id="formBerita" class="hidden">
                <label class="font-semibold">Judul<span class="text-red-500">*</span></label>
                <input name="judul_berita" placeholder="Judul" class="input input-bordered w-full mb-2">
                <label class="font-semibold">Deskripsi<span class="text-red-500">*</span></label>
                <textarea name="deskripsi_berita" class="textarea textarea-bordered w-full mb-2"></textarea>
                <label class="font-semibold">Gambar<span class="text-red-500">*</span></label>
                <input type="file" name="gambar_berita" class="file-input w-full"
                    accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                <small>Format: JPG, JPEG, PNG | Max 2MB</small>
            </div>

            <div id="formInfografis" class="hidden">
                <label class="font-semibold">Judul<span class="text-red-500">*</span></label>
                <input name="judul_infografis" placeholder="Judul" class="input input-bordered w-full mb-2">
                <label class="font-semibold">Deskripsi<span class="text-red-500">*</span></label>
                <textarea name="deskripsi_infografis" class="textarea textarea-bordered w-full mb-2"></textarea>
                <label class="font-semibold">Gambar<span class="text-red-500">*</span></label>
                <input type="file" name="gambar_infografis" class="file-input w-full"
                    accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                <small>Format: JPG, JPEG, PNG | Max 2MB</small>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button class="btn btn-primary">Simpan</button>
                <button type="button" onclick="closeModal('modalTambah')" class="btn">Batal</button>
            </div>
        </form>

    </div>
</div>
</div>


</tbody>
</table>
</div>

{{-- PAGINATION --}}
<div class="mt-6">
    {{ $publikasi->links('pagination::tailwind') }}
</div>


{{-- ================= SCRIPT ================= --}}
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden')
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden')
    }

    document.addEventListener('DOMContentLoaded', function () {
        const jenis = document.getElementById('jenis')
        const formBerita = document.getElementById('formBerita')
        const formInfografis = document.getElementById('formInfografis')

        if (jenis) {
            jenis.addEventListener('change', function () {
                formBerita.classList.add('hidden')
                formInfografis.classList.add('hidden')

                if (this.value === 'berita') formBerita.classList.remove('hidden')
                if (this.value === 'infografis') formInfografis.classList.remove(
                    'hidden')
            })

        }
    })
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const jenis = document.getElementById('jenis');

        const formBerita = document.getElementById('formBerita');
        const formInfografis = document.getElementById('formInfografis');

        const allForms = {
            berita: formBerita,
            infografis: formInfografis
        };

        function resetRequired() {
            Object.values(allForms).forEach(form => {
                if (!form) return;
                form.classList.add('hidden');

                form.querySelectorAll('input, textarea').forEach(el => {
                    el.removeAttribute('required');
                    el.setAttribute('disabled', true);
                });
            });
        }

        jenis.addEventListener('change', function () {
            resetRequired();

            let selected = allForms[this.value];

            if (selected) {
                selected.classList.remove('hidden');

                selected.querySelectorAll('input, textarea').forEach(el => {
                    el.removeAttribute('disabled');
                    el.setAttribute('required', 'required');
                });
            }
        });
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
