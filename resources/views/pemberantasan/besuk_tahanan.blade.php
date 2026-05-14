{{-- resources/views/pemberantasan/besuk_tahanan.blade.php --}}
@extends('layout.pemberantasan')
@section('title', 'Dashboard')

@section('content')
<div class="flex justify-center py-10">
    <div class="bg-white w-full max-w-6xl rounded-xl shadow-md border border-gray-200 p-6">

        {{-- Header Card --}}
        <div class="border-b border-gray-300 pb-3 mb-4 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-800">Pendaftaran Besuk Tahanan</h2>
        </div>

        {{-- Search & Filter Section (Responsif) --}}
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4">

            {{-- Input Search --}}
            <label class="flex items-center gap-2 border rounded-lg px-3 py-2 w-full sm:w-64">
                <svg class="h-[1em] opacity-50 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                        stroke="currentColor">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.3-4.3"></path>
                    </g>
                </svg>
                <input type="search" id="searchInput" placeholder="Cari data..." class="outline-none text-sm w-full" />
            </label>

            {{-- Filter Bulan & Tahun + Unduh --}}
            <form action="{{ route('pemberantasan.besuk_tahanan') }}" method="GET"
                class="flex flex-wrap justify-end items-center gap-2 w-full sm:w-auto">

                <select name="bulan" class="border rounded-md px-2 py-1 text-sm w-1/2 sm:w-auto"
                    onchange="this.form.submit()">
                    <option value="">Pilih Bulan</option>
                    @foreach ([1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                    7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'] as $num => $nama)
                        <option value="{{ $num }}"
                            {{ request('bulan') == $num ? 'selected' : '' }}>
                            {{ $nama }}</option>
                    @endforeach
                </select>

                <select name="tahun" class="border rounded-md px-2 py-1 text-sm w-1/2 sm:w-auto"
                    onchange="this.form.submit()">
                    <option value="">Pilih Tahun</option>
                    @for($i = now()->year; $i >= 2025; $i--)
                        <option value="{{ $i }}"
                            {{ request('tahun') == $i ? 'selected' : '' }}>
                            {{ $i }}</option>
                    @endfor
                </select>

                <a href="{{ route('pemberantasan.besuk_tahanan.export', ['bulan' => request('bulan'), 'tahun' => request('tahun')]) }}"
                    class="flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white rounded-md px-4 py-2 text-sm font-semibold w-full sm:w-auto text-center">
                    <i class="fa-solid fa-file-excel"></i>
                    Unduh
                </a>
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table id="dataTable" class="table table-zebra w-full text-sm">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th>No</th>
                        <th>Nomor Tahanan</th>
                        <th>Nama Tahanan</th>
                        <th>Nama Pembesuk</th>
                        <th>Tanggal Besuk</th>
                        <th>Hari Besuk</th>
                        <th>Jam Besuk</th>
                        <th>No Telepon</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $key => $item)
                        <tr>
                            <td>{{ $data->firstItem() + $key }}</td>
                            <td>{{ $item->tahanan->nomor_tahanan ?? '-' }}</td>
                            <td>{{ $item->nama_tahanan }}</td>
                            <td>{{ $item->nama_pembesuk }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_kedatangan)->format('d/m/Y') }}</td>
                            <td>{{ $item->hari_kunjungan }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') }}</td>
                            <td>{{ $item->no_hp }}</td>
                            <td>
                                <button onclick="openModal('modalDetail{{ $item->id }}')"
                                    class="btn btn-sm btn-info text-white">
                                    <i class="fa-solid fa-circle-info"></i>
                                </button>
                            </td>
                        </tr>
                        <div id="modalDetail{{ $item->id }}"
                            class="fixed inset-0 hidden z-[9999] bg-black/60 flex items-center justify-center">

                            <div
                                class="bg-white w-11/12 max-w-4xl rounded-xl shadow-lg p-6 max-h-[90vh] overflow-y-auto">

                                <h3 class="font-bold text-lg text-gray-800 border-b pb-2 mb-4">
                                    Detail Permohonan
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">

                                    {{-- KIRI --}}
                                    <div class="space-y-3">

                                        <h4 class="font-semibold text-gray-700 border-b pb-1">
                                            Data Permohonan
                                        </h4>

                                        {{-- NOMOR TAHANAN (FIX) --}}
                                        <div class="flex flex-col">
                                            <label class="font-semibold">Nomor Tahanan</label>
                                            <input type="text" class="border rounded-lg p-2 bg-gray-100"
                                                value="{{ $item->tahanan->nomor_tahanan ?? '-' }}"
                                                readonly>
                                        </div>

                                        {{-- NAMA TAHANAN --}}
                                        <div class="flex flex-col">
                                            <label class="font-semibold">Nama Tahanan</label>
                                            <input type="text" class="border rounded-lg p-2 bg-gray-100"
                                                value="{{ $item->nama_tahanan }}" readonly>
                                        </div>

                                        {{-- TANGGAL --}}
                                        <div class="flex flex-col">
                                            <label class="font-semibold">Tanggal Besuk</label>
                                            <input type="text" class="border rounded-lg p-2 bg-gray-100"
                                                value="{{ \Carbon\Carbon::parse($item->tanggal_kedatangan)->format('d-m-Y') }}"
                                                readonly>
                                        </div>

                                        {{-- HARI --}}
                                        <div class="flex flex-col">
                                            <label class="font-semibold">Hari Kunjungan</label>
                                            <input type="text" class="border rounded-lg p-2 bg-gray-100"
                                                value="{{ $item->hari_kunjungan }}" readonly>
                                        </div>

                                        {{-- JAM --}}
                                        <div class="flex flex-col">
                                            <label class="font-semibold">Jam Masuk Kunjungan</label>
                                            <input type="text" class="border rounded-lg p-2 bg-gray-100"
                                                value="{{ \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') }}"
                                                readonly>
                                        </div>

                                    </div>

                                    {{-- KANAN --}}
                                    <div class="space-y-3">

                                        <h4 class="font-semibold text-gray-700 border-b pb-1">
                                            Detail Pembesuk
                                        </h4>

                                        <div class="flex flex-col">
                                            <label class="font-semibold">Nama Pembesuk</label>
                                            <input type="text" class="border rounded-lg p-2 bg-gray-100"
                                                value="{{ $item->nama_pembesuk }}" readonly>
                                        </div>

                                        <div class="flex flex-col">
                                            <label class="font-semibold">Alamat Pembesuk</label>
                                            <input type="text" class="border rounded-lg p-2 bg-gray-100"
                                                value="{{ $item->alamat_pembesuk }}" readonly>
                                        </div>

                                        <div class="flex flex-col">
                                            <label class="font-semibold">No Telp Pembesuk</label>
                                            <input type="text" class="border rounded-lg p-2 bg-gray-100"
                                                value="{{ $item->no_hp }}" readonly>
                                        </div>

                                        <div class="flex flex-col">
                                            <label class="font-semibold">Self Assessment</label>
                                            <input type="text" class="border rounded-lg p-2 bg-gray-100"
                                                value="{{ $item->self_assessment }}" readonly>
                                        </div>

                                        <div class="flex flex-col">
                                            <label class="font-semibold">Hubungan</label>
                                            <input type="text" class="border rounded-lg p-2 bg-gray-100"
                                                value="{{ $item->hubungan }}" readonly>
                                        </div>

                                        {{-- BARANG (FIX tampil lebih rapi) --}}
                                        <div class="flex flex-col">
                                            <label class="font-semibold">Barang yang Dibawa</label>
                                            <input type="text" class="border rounded-lg p-2 bg-gray-100"
                                                value="{{ $item->barang ?? '-' }}"
                                                readonly>
                                        </div>

                                        {{-- FILE --}}
                                        <div>
                                            <label class="font-semibold">Kartu Identitas Pengunjung</label>

                                            <div class="flex gap-3 mt-1">

                                                <input class="flex-1 border rounded-lg p-2 bg-gray-100"
                                                    value="{{ basename($item->foto_identitas) }}" readonly>

                                                <a href="{{ route('pemberantasan.besuk_tahanan.viewSurat', $item->id) }}"
                                                    target="_blank"
                                                    class="bg-sky-500 hover:bg-sky-600 text-white px-3 py-2 rounded-md">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>

                                                <a href="{{ route('pemberantasan.besuk_tahanan.downloadSurat', $item->id) }}"
                                                    class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-2 rounded-md">
                                                    <i class="fa-solid fa-download"></i>
                                                </a>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                                
                                <div class="mt-4 text-sm italic text-gray-600 border-t pt-2">
                                    Data yang diisikan dalam formulir ini benar dan menjadi tanggung jawab pemohon.
                                </div>

                                <div class="modal-action">
                                    <button onclick="closeModal('modalDetail{{ $item->id }}')"
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                                        Tutup
                                    </button>
                                </div>

                            </div>
                        </div>


                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-gray-500 py-4">
                                Data belum tersedia untuk
                                @if(request('bulan') && request('tahun'))
                                    bulan <strong>{{ \Carbon\Carbon::create()->month((int) request('bulan'))->translatedFormat('F') }}</strong>
                                    tahun <strong>{{ request('tahun') }}</strong>.
                                @elseif(request('bulan'))
                                    bulan
                                    <strong>{{ \Carbon\Carbon::create()->month((int) request('bulan'))->translatedFormat('F') }}</strong>.
                                @elseif(request('tahun'))
                                    tahun <strong>{{ request('tahun') }}</strong>.
                                @else
                                    periode ini.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6  overflow-hidden">
            {{ $data->links('pagination::tailwind') }}
        </div>


    </div>
</div>

{{-- SEARCH SCRIPT --}}
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
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
                if (cell.textContent.toLowerCase().includes(keyword)) match = true;
            });

            row.style.display = match ? '' : 'none';
            if (match) visibleCount++;
        });

        emptyRow.style.display = visibleCount === 0 ? '' : 'none';
    });

</script>
@endsection
