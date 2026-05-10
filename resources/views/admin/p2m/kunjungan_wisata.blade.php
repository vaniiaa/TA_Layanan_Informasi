{{-- resources/views/admin/p2m/kunjungan_wisata.blade.php --}}
@extends('layout.admin')

@section('content')
<div class="flex justify-center py-10">
    <div class="bg-white w-full max-w-6xl rounded-xl shadow-md border border-gray-200 p-6">

        {{-- Header Card --}}
        <div class="border-b border-gray-300 pb-3 mb-4 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-800">
                Permohonan Kunjungan Wisata Edukasi (DOEMBA)
            </h2>
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
            <form action="{{ route('admin.p2m.kunjungan_wisata.index') }}" method="GET"
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

                <a href="{{ route('admin.laporan.export.wisata', ['bulan' => request('bulan'), 'tahun' => request('tahun')]) }}"
                    class="flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white rounded-md px-4 py-2 text-sm font-semibold w-full sm:w-auto text-center">
                    <i class="fa-solid fa-file-excel"></i> Unduh
                </a>
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table id="dataTable" class="table table-bordered table-striped text-sm">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NPSN</th>
                        <th>Nama Sekolah</th>
                        <th>Alamat</th>
                        <th>No Telp</th>
                        <th>Tanggal Kegiatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($wisata as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($wisata->currentPage()-1)*$wisata->perPage() }}
                            </td>
                            <td>{{ $item->nama_lengkap }}</td>
                            <td>{{ $item->sekolah->npsn ?? '-' }}</td>
                            <td>{{ $item->sekolah->nama_sekolah ?? '-' }}</td>
                            <td>{{ $item->sekolah->alamat ?? '-' }}</td>
                            <td>{{ $item->no_telp }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d-m-Y') }}
                            </td>
                            <td>
                                <button onclick="openModal('modalDetail{{ $item->id }}')"
                                    class="btn btn-sm btn-info text-white">
                                    <i class="fa-solid fa-circle-info"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- ================= MODAL DETAIL ================= --}}
                        <div id="modalDetail{{ $item->id }}"
                            class="fixed inset-0 hidden z-[9999] bg-black/60 flex items-center justify-center">

                            <div class="bg-white w-11/12 max-w-2xl rounded-xl shadow-lg p-6
                        max-h-[90vh] overflow-y-auto">

                                <h3 class="font-bold text-lg text-gray-800 border-b pb-2 mb-4">
                                    Detail Permohonan Wisata Edukasi
                                </h3>

                                <div class="space-y-4 text-sm">

                                    <div class="flex flex-col">
                                        <label class="font-semibold">Nama Lengkap</label>
                                        <input class="border rounded-lg p-2 bg-gray-100"
                                            value="{{ $item->nama_lengkap }}" readonly>
                                    </div>
                                    <div class="flex flex-col">
                                        <label class="font-semibold">NPSN</label>
                                        <input class="border rounded-lg p-2 bg-gray-100"
                                            value="{{ $item->sekolah->npsn ?? '-' }}"
                                            readonly>
                                    </div>
                                    <div class="flex flex-col">
                                        <label class="font-semibold">Nama Sekolah</label>
                                        <input class="border rounded-lg p-2 bg-gray-100"
                                            value="{{ $item->sekolah->nama_sekolah ?? '-' }}"
                                            readonly>
                                    </div>
                                    <div class="flex flex-col">
                                        <label class="font-semibold">Alamat</label>
                                        <input class="border rounded-lg p-2 bg-gray-100"
                                            value="{{ $item->sekolah->alamat ?? '-' }}"
                                            readonly>
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="font-semibold">No Telp</label>
                                        <input class="border rounded-lg p-2 bg-gray-100" value="{{ $item->no_telp }}"
                                            readonly>
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="font-semibold">Tanggal Kegiatan</label>
                                        <input class="border rounded-lg p-2 bg-gray-100"
                                            value="{{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d-m-Y') }}"
                                            readonly>
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="font-semibold">Waktu Kegiatan</label>
                                        <input class="border rounded-lg p-2 bg-gray-100"
                                            value="{{ \Carbon\Carbon::parse($item->waktu_kegiatan)->format('H:i') }}"
                                            readonly>
                                    </div>
                                    <div class="flex flex-col">
                                        <label class="font-semibold">Peserta Kegiatan</label>
                                        <input class="border rounded-lg p-2 bg-gray-100"
                                            value="{{ $item->jumlah_peserta }}" readonly>
                                    </div>
                                    <div>
                                        <label class="font-semibold">Surat Permohonan</label>
                                        <div class="flex gap-3">
                                            {{-- Nama File --}}
                                            <input class="flex-1 border rounded-lg p-2 bg-gray-100"
                                                value="{{ basename($item->surat_permohonan) }}" readonly>

                                            {{-- Lihat File --}}
                                            <a href="{{ route('admin.wisata.viewSurat', $item->id) }}"
                                                target="_blank"
                                                class="bg-sky-500 hover:bg-sky-600 text-white px-3 py-2 rounded-md">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            {{-- Download File --}}
                                            <a href="{{ route('admin.wisata.downloadSurat', $item->id) }}"
                                                class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-2 rounded-md">
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                        </div>
                                    </div>

                                </div>

                                <div class="mt-4 text-sm italic text-gray-600 border-t pt-2">
                                    Data yang diisikan benar dan menjadi tanggung jawab pemohon.
                                </div>

                                <div class="flex justify-end mt-4">
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
            {{ $wisata->links('pagination::tailwind') }}
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
