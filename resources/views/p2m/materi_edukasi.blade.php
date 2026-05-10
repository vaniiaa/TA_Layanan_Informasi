{{-- resources/views/p2m/materi_edukasi.blade.php --}}
@extends('layout.p2m')
@section('title', 'Materi Edukasi')

@section('content')
<div class="flex justify-center py-10">
    <div class="bg-white w-full max-w-6xl rounded-xl shadow-md border border-gray-200 p-6">

        {{-- HEADER --}}
        <div class="border-b border-gray-300 pb-3 mb-4 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-800">Materi Edukasi</h2>
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
                    @foreach($materi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ ucfirst($item->jenis) }}</td>
                            <td>{{ $item->judul }}</td>

                            <td>{{ Str::limit($item->deskripsi, 40) }}</td>
                            <td>
                                {{ $item->user->name ?? '-' }}
                            </td>
                            <td class="flex gap-2">
                                <button onclick='showDetail(@json($item))' class="btn btn-sm btn-info text-white">
                                    <i class="fa-solid fa-circle-info"></i>
                                </button>

                                <button onclick='showEdit(@json($item))' class="btn btn-sm btn-success text-white">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>

                                <button type="button" onclick="confirmDelete({{ $item->id }})"
                                    class="btn btn-sm btn-error text-white">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $item->id }}" method="POST"
                                    action="{{ route('p2m.materi_edukasi.destroy', $item->id) }}"
                                    class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-6">
            {{ $materi->links('pagination::tailwind') }}
        </div>
    </div>
</div>

{{-- ================= MODAL TAMBAH ================= --}}
<div id="modalTambah" class="fixed inset-0 hidden z-[9999] bg-black/60 flex items-center justify-center">

    <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6 max-h-[90vh] overflow-y-auto">

        <h3 class="font-bold text-lg border-b pb-2 mb-4">Tambah Materi Edukasi</h3>

        <form action="{{ route('p2m.materi_edukasi.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="font-semibold">Jenis Edukasi<span class="text-red-500">*</span></label>
                <select id="jenisTambah" name="jenis" class="select select-bordered w-full" required>
                    <option value="">-- Pilih --</option>
                    <option value="artikel">Artikel</option>
                    <option value="infografis">Infografis</option>
                    <option value="modul">Modul</option>
                    <option value="video">Video</option>
                </select>
            </div>

            {{-- ARTIKEL --}}
            <div id="formArtikelTambah" class="hidden">
                <label class="font-semibold">Judul<span class="text-red-500">*</span></label>
                <input name="judul_artikel" class="input input-bordered w-full mb-2">
                <label class="font-semibold">Deskripsi<span class="text-red-500">*</span></label>
                <textarea name="deskripsi_artikel" class="textarea textarea-bordered w-full mb-2"></textarea>
                <label class="font-semibold">Upload Gambar<span class="text-red-500">*</span></label>
               <input type="file" name="gambar_artikel" 
                      class="file-input w-full 
                      accept=".jpg,.jpeg,.png,image/jpeg,image/png">

                <small class="text-gray-500">
                    Format: JPG, JPEG, PNG | Max 2MB
                </small>
            </div>

            {{-- INFOGRAFIS --}}
            <div id="formInfografisTambah" class="hidden">
                <label class="font-semibold">Judul<span class="text-red-500">*</span></label>
                <input name="judul_infografis" class="input input-bordered w-full mb-2">
                <label class="font-semibold">Deskripsi<span class="text-red-500">*</span></label>
                <textarea name="deskripsi_infografis" class="textarea textarea-bordered w-full mb-2"></textarea>
                <label class="font-semibold">Upload Infografis<span class="text-red-500">*</span></label>
                <input type="file" name="gambar_infografis" class="file-input w-full"
                    accept=".jpg,.jpeg,.png,image/jpeg,image/png">

                <small class="text-gray-500">
                    Format: JPG, JPEG, PNG | Max 2MB
                </small>
            </div>

            {{-- MODUL --}}
            <div id="formModulTambah" class="hidden">
                <label class="font-semibold">Judul Modul<span class="text-red-500">*</span></label>
                <input name="judul_modul" class="input input-bordered w-full mb-2">
                <label class="font-semibold">Deskripsi<span class="text-red-500">*</span></label>
                <textarea name="deskripsi_modul" class="textarea textarea-bordered w-full mb-2"></textarea>
                <label class="font-semibold">Upload Modul (PDF)</label>
                <input type="file" name="file_modul"
                       class="file-input w-full"
                       accept=".pdf,application/pdf">

                <small class="text-gray-500">
                    Format: PDF | Max 2MB
                </small>
            </div>

            {{-- VIDEO --}}
            <div id="formVideoTambah" class="hidden">
                <label class="font-semibold">Judul Video<span class="text-red-500">*</span></label>
                <input name="judul_video" class="input input-bordered w-full mb-2">
                <label class="font-semibold">Deskripsi<span class="text-red-500">*</span></label>
                <textarea name="deskripsi_video" class="textarea textarea-bordered w-full mb-2"></textarea>
                <label class="font-semibold">Upload Video (MP4)<span class="text-red-500">*</span></label>
             <input type="file" name="video_file"
                    class="file-input w-full"
                    accept=".mp4,video/mp4">

                <small class="text-gray-500">
                    Format: MP4 | Max 10MB
                </small>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal('modalTambah')" class="btn">Batal</button>
                <button class="btn btn-primary">Simpan</button>

            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL DETAIL MATERI EDUKASI ================= --}}
<div id="modalDetail" class="fixed inset-0 hidden z-[9999] bg-black/60 flex items-center justify-center">

    <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6 max-h-[90vh] overflow-y-auto">

        {{-- HEADER --}}
        <h3 class="font-bold text-lg border-b pb-2 mb-4">
            Detail Materi Edukasi
        </h3>

        {{-- BODY --}}
        <div class="space-y-4 text-sm">

            {{-- JENIS --}}
            <div>
                <label class="font-semibold">Jenis Materi</label>
                <input id="dJenis" class="w-full border rounded-lg p-2 bg-gray-100" readonly>
            </div>

            {{-- JUDUL --}}
            <div>
                <label class="font-semibold">Judul</label>
                <input id="dJudul" class="w-full border rounded-lg p-2 bg-gray-100" readonly>
            </div>

            {{-- DESKRIPSI --}}
            <div>
                <label class="font-semibold">Deskripsi</label>
                <textarea id="dDeskripsi" class="w-full border rounded-lg p-2 bg-gray-100" rows="4" readonly></textarea>
            </div>

            {{-- MEDIA --}}
            <div id="detailMedia">
                {{-- Diisi JS:
                     - Artikel / Infografis → Gambar + tombol eye
                     - Modul → File PDF + tombol download
                     - Video → Link / file + tombol play --}}
            </div>

            {{-- TANGGAL --}}
            <div>
                <label class="font-semibold">Tanggal Upload</label>
                <input id="dTanggal" class="w-full border rounded-lg p-2 bg-gray-100" readonly>
            </div>

        </div>

        {{-- FOOTER --}}
        <div class="text-right mt-6">
            <button onclick="closeModal('modalDetail')" class="bg-red-600 text-white px-4 py-2 rounded-lg">
                Tutup
            </button>
        </div>

    </div>
</div>


{{-- ================= MODAL EDIT ================= --}}
<div id="modalEdit" class="fixed inset-0 hidden z-[9999] bg-black/60 flex items-center justify-center">

    <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6 max-h-[90vh] overflow-y-auto">

        <h3 class="font-bold text-lg border-b pb-2 mb-4">Edit Materi Edukasi</h3>

        <form id="formEdit" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="font-semibold">Judul</label>
                <input id="edit_judul" name="judul" class="input input-bordered w-full">
            </div>

            <div class="mb-3">
                <label class="font-semibold">Deskripsi</label>
                <textarea id="edit_deskripsi" name="deskripsi" class="textarea textarea-bordered w-full"></textarea>
            </div>

            {{-- EDIT ARTIKEL --}}
            <div id="editArtikel" class="hidden">
                <label class="font-semibold">Gambar Artikel</label>
                <input type="file" name="gambar_artikel" class="file-input w-full">
            </div>

            {{-- EDIT INFOGRAFIS --}}
            <div id="editInfografis" class="hidden">
                <label class="font-semibold">Gambar Infografis</label>
                <input type="file" name="gambar_infografis" class="file-input w-full">
            </div>

            {{-- EDIT MODUL --}}
            <div id="editModul" class="hidden">
                <label class="font-semibold">Upload Modul (PDF)</label>
                <input type="file" name="file_modul" accept="application/pdf" class="file-input w-full">
            </div>

            {{-- EDIT VIDEO --}}
            <div id="editVideo" class="hidden">
                <label class="font-semibold">Link Youtube</label>
                <input id="edit_link_video" name="link_video" class="input input-bordered w-full mb-2">
                <label class="font-semibold">Upload Video (MP4)</label>
                <input type="file" name="video_file" accept="video/mp4" class="file-input w-full">
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal('modalEdit')" class="btn">Batal</button>
                <button class="btn btn-primary">Simpan</button>

            </div>
        </form>
    </div>
</div>

    </div>
</div>


{{-- ================= SCRIPT ================= --}}
<script>
    function openModal(id){ document.getElementById(id).classList.remove('hidden') }
function closeModal(id){ document.getElementById(id).classList.add('hidden') }

// TAMBAH
document.getElementById('jenisTambah').addEventListener('change', function () {

    const forms = [
        'formArtikelTambah',
        'formInfografisTambah',
        'formModulTambah',
        'formVideoTambah'
    ];

    // Reset semua form
    forms.forEach(id => {
        const form = document.getElementById(id);

        form.classList.add('hidden');

        form.querySelectorAll('input, textarea, select').forEach(el => {
            el.removeAttribute('required');   // ❌ hapus wajib
            el.setAttribute('disabled', true); // ❗ nonaktifkan
        });
    });

    // Tentukan form aktif
    let selectedForm = null;

    if (this.value === 'artikel') selectedForm = 'formArtikelTambah';
    if (this.value === 'infografis') selectedForm = 'formInfografisTambah';
    if (this.value === 'modul') selectedForm = 'formModulTambah';
    if (this.value === 'video') selectedForm = 'formVideoTambah';

    // Aktifkan form terpilih
    if (selectedForm) {
        const form = document.getElementById(selectedForm);

        form.classList.remove('hidden');

        form.querySelectorAll('input, textarea, select').forEach(el => {
            el.removeAttribute('disabled'); // ✅ aktif
            el.setAttribute('required', 'required'); // ✅ wajib isi
        });
    }
});

    // DETAIL
    function showDetail(item) {

       document.getElementById('dJenis').value = item.jenis ?? '-'
       document.getElementById('dJudul').value = item.judul ?? '-'
       document.getElementById('dDeskripsi').value = item.deskripsi ?? '-'

        // FIX TANGGAL UPLOAD
        document.getElementById('dTanggal').value =
            item.created_at ?
            new Date(item.created_at).toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            }) :
            '-'

        let mediaHtml = ''

        // GAMBAR
        if (item.gambar) {
            mediaHtml = `
            <label class="font-semibold">Gambar</label>
            <div class="flex gap-3">
                <input class="flex-1 border rounded-lg p-2 bg-gray-100"
                    value="${item.gambar}" readonly>
                <a href="/storage/${item.gambar}" target="_blank"
                    class="bg-sky-500 text-white px-3 py-2 rounded-md">
                    <i class="fa-solid fa-eye"></i>
                </a>
            </div>
        `
        }

        // MODUL (PREVIEW)
        if (item.file_modul) {
            mediaHtml = `
            <label class="font-semibold">File Modul</label>
            <div class="flex gap-3">
                <input class="flex-1 border rounded-lg p-2 bg-gray-100"
                    value="${item.file_modul}" readonly>
                <a href="/storage/${item.file_modul}" target="_blank"
                    class="bg-sky-500 text-white px-3 py-2 rounded-md">
                    <i class="fa-solid fa-eye"></i>
                </a>
            </div>
        `
        }

        // VIDEO
        if (item.video_file) {
            mediaHtml = `
            <label class="font-semibold">Video</label>
            <video src="/storage/${item.video_file}"
                controls
                class="w-full rounded-lg border mt-1">
            </video>
        `
        }

        document.getElementById('detailMedia').innerHTML = mediaHtml
        openModal('modalDetail')
    }


    // EDIT
    function showEdit(item) {
        document.getElementById('formEdit').action = `/p2m/materi_edukasi/update/${item.id}`
        document.getElementById('edit_judul').value = item.judul
        document.getElementById('edit_deskripsi').value = item.deskripsi

        ;
        ['editArtikel', 'editInfografis', 'editModul', 'editVideo']
        .forEach(id => document.getElementById(id).classList.add('hidden'))

        if (item.jenis === 'artikel') editArtikel.classList.remove('hidden')
        if (item.jenis === 'infografis') editInfografis.classList.remove('hidden')
        if (item.jenis === 'modul') editModul.classList.remove('hidden')
        if (item.jenis === 'video') editVideo.classList.remove('hidden')

        openModal('modalEdit')
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