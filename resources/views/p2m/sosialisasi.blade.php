{{-- resources/views/p2m/sosialisasi.blade.php --}}
@extends('layout.p2m')

@section('title', 'Sosialisasi')

@section('content')
<div class="flex justify-center py-10">
    <div class="bg-white w-full max-w-6xl rounded-xl shadow-md border border-gray-200 p-6">

        {{-- Header --}}
        <div class="border-b border-gray-300 pb-3 mb-4 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-800">Permohonan Sosialisasi</h2>
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

            {{-- Filter Bulan & Tahun + Unduh --}}
            <form action="{{ route('p2m.sosialisasi.indexP2M') }}" method="GET"
                class="flex flex-wrap justify-end items-center gap-2 w-full sm:w-auto">

                <select name="bulan" class="border rounded-md px-2 py-1 text-sm w-1/2 sm:w-auto"
                    onchange="this.form.submit()">
                    <option value="">Pilih Bulan</option>
                    
                       @foreach ([1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                       7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'] as $num => $nama)
                        <option value="{{ $num }}"
                            {{ request('bulan') == $num ? 'selected' : '' }}>
                            {{ $nama }}
                        </option>
                    @endforeach
                </select>

                <select name="tahun" class="border rounded-md px-2 py-1 text-sm w-1/2 sm:w-auto"
                    onchange="this.form.submit()">
                    <option value="">Pilih Tahun</option>
                    @for($i = now()->year; $i >= 2025; $i--)
                        <option value="{{ $i }}"
                            {{ request('tahun') == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>

                <a href="{{ route('p2m.laporan.export.sosialisasi', ['bulan' => request('bulan'), 'tahun' => request('tahun')]) }}"
                    class="flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white rounded-md px-4 py-2 text-sm font-semibold w-full sm:w-auto text-center">
                    <i class="fa-solid fa-file-excel"></i> Unduh
                </a>
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table id="dataTable" class="table table-zebra w-full text-sm">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Instansi</th>
                        <th>Alamat</th>
                        <th>No HP</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($data as $index => $item)
                        <tr>
                            <td>{{ $data->firstItem() + $index }}</td>
                            <td>{{ $item->nama_lengkap }}</td>
                            <td>{{ $item->instansi }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->no_hp }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d-m-Y') }}
                            </td>
                            <td>{{ $item->waktu_kegiatan }}</td>
                            <td>
                                <button onclick="openModal('modalDetail{{ $item->id }}')"
                                    class="btn btn-sm btn-info text-white">
                                    <i class="fa-solid fa-circle-info"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- ================= MODAL DETAIL (TANPA DIALOG) ================= --}}
                        <div id="modalDetail{{ $item->id }}"
                            class="fixed inset-0 hidden z-[9999] bg-black/60 flex items-center justify-center">

                            <div class="bg-white w-11/12 max-w-4xl rounded-xl shadow-lg p-6 max-h-[90vh] overflow-y-auto">

                                <h3 class="font-bold text-lg text-gray-800 border-b pb-2 mb-4">
                                    Detail Permohonan Sosialisasi
                                </h3>

                                <div class="grid grid-cols-2 gap-6 text-sm">

                                    {{-- Kiri --}}
                                    <div class="space-y-3">
                                        <h4 class="font-semibold text-gray-700 border-b pb-1">Data Pemohon</h4>

                                        <div class="flex flex-col">
                                            <label class="font-semibold">Nama Lengkap</label>
                                            <input class="border rounded-lg p-2 bg-gray-100"
                                                value="{{ $item->nama_lengkap }}" readonly>
                                        </div>

                                        <div class="flex flex-col">
                                            <label class="font-semibold">Instansi/Organisasi</label>
                                            <input class="border rounded-lg p-2 bg-gray-100"
                                                value="{{ $item->instansi }}" readonly>
                                        </div>

                                        <div class="flex flex-col">
                                            <label class="font-semibold">Alamat</label>
                                            <input class="border rounded-lg p-2 bg-gray-100"
                                                value="{{ $item->alamat }}" readonly>
                                        </div>

                                        <div class="flex flex-col">
                                            <label class="font-semibold">No HP/WA Aktif</label>
                                            <input class="border rounded-lg p-2 bg-gray-100"
                                                value="{{ $item->no_hp }}" readonly>
                                        </div>
                                    </div>

                                    {{-- Kanan --}}
                                    <div class="space-y-3">
                                        <h4 class="font-semibold text-gray-700 border-b pb-1">Detail Kegiatan</h4>
                                        <div class="flex flex-col">
                                            <label class="font-semibold">Nama Kegiatan</label>
                                            <input type="text" class="border rounded-lg p-2 bg-gray-100"
                                                value="{{ $item->nama_kegiatan }}" readonly>
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="font-semibold">Waktu Kegiatan</label>
                                            <input type="text" class="border rounded-lg p-2 bg-gray-100"
                                                value="{{ $item->waktu_kegiatan }}" readonly>
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="font-semibold">Tanggal Kegiatan</label>
                                            <input type="text" class="border rounded-lg p-2 bg-gray-100"
                                                value="{{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d-m-Y') }}"
                                                readonly>
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="font-semibold">Lokasi Kegiatan</label>
                                            <input type="text" class="border rounded-lg p-2 bg-gray-100"
                                                value="{{ $item->lokasi }}" readonly>
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="font-semibold">Peserta Kegiatan</label>
                                            <input type="text" class="border rounded-lg p-2 bg-gray-100"
                                                value="{{ $item->peserta }}" readonly>
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="font-semibold">Jumlah Peserta</label>
                                            <input type="text" class="border rounded-lg p-2 bg-gray-100"
                                                value="{{ $item->jumlah_peserta }}" readonly>
                                        </div>
                                        <div>
                                            <label class="font-semibold">Surat Permohonan</label>
                                            <div class="flex gap-3">
                                                {{-- Nama File --}}
                                                <input class="flex-1 border rounded-lg p-2 bg-gray-100"
                                                    value="{{ basename($item->surat_permohonan) }}" readonly>

                                                {{-- Lihat File --}}
                                                <a href="{{ route('p2m.sosialisasi.view_surat', $item->id) }}"
                                                    target="_blank"
                                                    class="bg-sky-500 hover:bg-sky-600 text-white px-3 py-2 rounded-md">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>

                                                {{-- Download File --}}
                                                <a href="{{ route('p2m.sosialisasi.download_surat', $item->id) }}"
                                                    class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-2 rounded-md">
                                                    <i class="fa-solid fa-download"></i>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <div class="mt-4 text-sm italic text-gray-600 border-t pt-2">
                                    Data yang diisikan dalam formulir ini benar dan bertanggung jawab atas hal tersebut.
                                </div>

                                <div class="flex justify-end mt-6">
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
                                <blade
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

{{-- SCRIPT MODAL --}}
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
            const cells = row.getElementsByTagName('td');
            let match = false;

            for (let i = 0; i < cells.length; i++) {
                const cellText = cells[i].textContent.toLowerCase();
                if (cellText.includes(keyword)) {
                    match = true;
                    break;
                }
            }

            // Sembunyikan baris "kosong" dari hasil filter sebelumnya
            if (row !== emptyRow) {
                row.style.display = match ? '' : 'none';
                if (match) visibleCount++;
            }
        });

        // Tampilkan pesan jika tidak ada baris yang cocok
        emptyRow.style.display = visibleCount === 0 ? '' : 'none';
    });

</script>

@endsection
