{{-- resources/views/admin/tambah_akun.blade.php --}}
@extends('layout.admin')
@section('title', 'Kelola Akun')

@section('content')

<div class="flex justify-center py-10">
    <div class="bg-white w-full max-w-6xl rounded-xl shadow-md border border-gray-200 p-6">

        {{-- Header --}}
        <div class="border-b border-gray-300 pb-3 mb-4 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-800">
                Kelola Akun
            </h2>
        </div>

        {{-- Search & Button --}}
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4">

            {{-- Search --}}
            <label class="flex items-center gap-2 border rounded-lg px-3 py-2 w-full sm:w-64">
                <svg class="h-[1em] opacity-50"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24">

                    <circle cx="11" cy="11" r="8"
                        stroke="currentColor"
                        fill="none" />

                    <path d="m21 21-4.3-4.3"
                        stroke="currentColor" />
                </svg>

                <input type="search"
                    id="searchInput"
                    placeholder="Cari user..."
                    class="outline-none text-sm w-full">
            </label>

            {{-- Button tambah --}}
            <button onclick="openModal('modalTambah')"
                class="btn btn-primary text-sm">

                <i class="fa-solid fa-plus mr-2"></i>
                Tambah Akun
            </button>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">

            <table id="dataTable"
                class="table table-zebra w-full text-sm">

                <thead class="bg-gray-200 text-black">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($users as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>                          
                                {{ $item->role->name }}                           
                        </td>

                        <td class="flex gap-2">

                            {{-- Edit --}}
                            <button
                                onclick="openModal('modalEdit{{ $item->id }}')"
                                class="btn btn-sm btn-success text-white">

                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>

                            {{-- Hapus --}}
                            <button type="button"
                                onclick="confirmDelete({{ $item->id }})"
                                class="btn btn-sm btn-error text-white">

                                <i class="fa-solid fa-trash"></i>
                            </button>

                            <form id="delete-form-{{ $item->id }}"
                                action="{{ route('users.destroy', $item->id) }}"
                                method="POST"
                                class="hidden">

                                @csrf
                                @method('DELETE')
                            </form>

                        </td>
                    </tr>

                    {{-- Modal Edit --}}
                    <div id="modalEdit{{ $item->id }}"
                        class="fixed inset-0 hidden z-[9999] bg-black/60 flex items-center justify-center">

                        <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6">

                            <h3 class="font-bold text-lg mb-4">
                                Edit Akun
                            </h3>

                            <form method="POST"
                                action="{{ route('users.update', $item->id) }}">

                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="font-semibold">Nama</label>

                                    <input type="text"
                                        name="name"
                                        value="{{ $item->name }}"
                                        class="input input-bordered w-full"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label class="font-semibold">Email</label>

                                    <input type="email"
                                        name="email"
                                        value="{{ $item->email }}"
                                        class="input input-bordered w-full"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label class="font-semibold">Password Baru</label>

                                    <input type="password"
                                        name="password"
                                        class="input input-bordered w-full">

                                    <small class="text-gray-500">
                                        Kosongkan jika tidak ingin mengganti password
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <label class="font-semibold">Role</label>

                                    <select name="role_id"
                                        class="select select-bordered w-full"
                                        required>

                                        @foreach($roles as $role)

                                        <option value="{{ $role->id }}"
                                            {{ $item->role_id == $role->id ? 'selected' : '' }}>

                                            {{ $role->name }}
                                        </option>

                                        @endforeach

                                    </select>
                                </div>

                                <div class="flex justify-end gap-2">

                                    <button type="button"
                                        onclick="closeModal('modalEdit{{ $item->id }}')"
                                        class="btn">

                                        Batal
                                    </button>

                                    <button class="btn btn-primary">
                                        Simpan
                                    </button>

                                </div>
                            </form>
                        </div>
                    </div>

                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div id="modalTambah"
    class="fixed inset-0 hidden z-[9999] bg-black/60 flex items-center justify-center">

    <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6">

        <h3 class="font-bold text-lg mb-4">
            Tambah Akun
        </h3>

        <form action="{{ route('users.store') }}"
            method="POST">

            @csrf

            <div class="mb-3">
                <label class="font-semibold">Nama<span class="text-red-500">*</span></label>

                <input type="text"
                    name="name"
                    class="input input-bordered w-full"
                    required>
            </div>

            <div class="mb-3">
                <label class="font-semibold">Email<span class="text-red-500">*</span></label>

                <input type="email"
                    name="email"
                    class="input input-bordered w-full"
                    required>
            </div>

            <div class="mb-3">
                <label class="font-semibold">Password<span class="text-red-500">*</span></label>

                <input type="password"
                    name="password"
                    class="input input-bordered w-full"
                    required>
            </div>

            <div class="mb-3">
                <label class="font-semibold">Role<span class="text-red-500">*</span></label>

                <select name="role_id"
                    class="select select-bordered w-full"
                    required>

                    <option value="">-- Pilih Role --</option>

                    @foreach($roles as $role)

                    <option value="{{ $role->id }}">
                        {{ $role->name }}
                    </option>

                    @endforeach

                </select>
            </div>

            <div class="flex justify-end gap-2">

                <button type="button"
                    onclick="closeModal('modalTambah')"
                    class="btn">

                    Batal
                </button>

                <button class="btn btn-primary">
                    Simpan
                </button>

            </div>
        </form>
    </div>
</div>

{{-- SWEET ALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

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

    // SEARCH
    const searchInput = document.getElementById('searchInput');
    const rows = document.querySelectorAll('#dataTable tbody tr');

    searchInput.addEventListener('keyup', function () {

        const keyword = this.value.toLowerCase();

        rows.forEach(row => {

            const text = row.innerText.toLowerCase();

            row.style.display =
                text.includes(keyword) ? '' : 'none';
        });

    });
</script>

@endsection