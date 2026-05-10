{{-- resources/views/pemberantasan/assessment.blade.php --}}
@extends('layout.pemberantasan')
@section('title', 'Dashboard')

@section('content')
<div class="flex justify-center py-10">
    <div class="bg-white w-full max-w-6xl rounded-xl shadow-md border border-gray-200 p-6">

        {{-- Header Card --}}
        <div class="border-b border-gray-300 pb-3 mb-4 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-800">Pendaftaran Assessment Terpadu (TAT)</h2>
        </div>

        {{-- Search & Filter --}}
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4">

            {{-- Search --}}
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

            {{-- Filter + Export --}}
            <form action="{{ route('pemberantasan.assessment') }}" method="GET"
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

                <a href="{{ route('pemberantasan.assessment.export', ['bulan'=>request('bulan'),'tahun'=>request('tahun')]) }}"
                    class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white
                  rounded-md px-4 py-2 text-sm font-semibold">
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
                        <th>NIK</th>
                        <th>Nama Tersangka</th>
                        <th>Barang Bukti</th>
                        <th>Berat Barang Bukti</th>
                        <th>Hasil Tes Urine</th>
                        <th>Nama Penyidik</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $key => $item)
                        <tr>
                            <td>{{ $data->firstItem() + $key }}</td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->nama_tersangka }}</td>
                            <td>{{ is_array($item->barang_bukti) ? implode(', ', $item->barang_bukti) : '-' }}
                            </td>
                            <td>{{ $item->berat_barang_bukti ?? '-' }}</td>
                            <td>{{ is_array($item->hasil_urine) ? implode(', ', $item->hasil_urine) : '-' }}
                            </td>
                            <td>{{ $item->nama_penyidik }}</td>
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

                            <div class="bg-white w-11/12 max-w-4xl rounded-xl shadow-lg p-6
                        max-h-[90vh] overflow-y-auto">

                                {{-- HEADER --}}
                                <div class="px-6 py-4 border-b">
                                    <h3 class="font-bold text-lg text-gray-800">
                                        Detail Pendaftaran Assessment Terpadu (TAT)
                                    </h3>
                                    <h3 class="font-bold text-lg text-gray-800">
                                        NIK {{ $item->nik }}
                                    </h3>
                                </div>

                                {{-- BODY --}}
                                <div class="p-6 text-sm">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">



                                        {{-- ================= KIRI ================= --}}
                                        <div class="space-y-3">

                                            <h4 class="font-semibold text-gray-700 border-b pb-1">
                                                Data Penyidikan
                                            </h4>

                                            <div>
                                                <label class="font-semibold">NIK</label>
                                                <input class="border rounded-lg p-2 bg-gray-100 w-full"
                                                    value="{{ $item->nik }}" readonly>
                                            </div>

                                            <div>
                                                <label class="font-semibold">Nama Lengkap Tersangka</label>
                                                <input class="border rounded-lg p-2 bg-gray-100 w-full"
                                                    value="{{ $item->nama_tersangka }}" readonly>
                                            </div>

                                            {{-- Identitas --}}
                                            @if($item->file_identitas)
                                                <div>
                                                    <label class="font-semibold mb-1 block">Identitas Tersangka</label>
                                                    <div class="flex gap-3 items-center">
                                                        <input class="flex-1 border rounded-lg p-2 bg-gray-100"
                                                            value="{{ basename($item->file_identitas) }}" readonly>

                                                        <a href="{{ asset('storage/'.$item->file_identitas) }}"
                                                            target="_blank"
                                                            class="bg-sky-500 hover:bg-sky-600 text-white px-3 py-2 rounded-md">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>

                                                        <a href="{{ asset('storage/'.$item->file_identitas) }}"
                                                            download
                                                            class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-2 rounded-md">
                                                            <i class="fa-solid fa-download"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif

                                            <div>
                                                <label class="font-semibold">Berat Barang Bukti</label>
                                                <input class="border rounded-lg p-2 bg-gray-100 w-full"
                                                    value="{{ $item->berat_barang_bukti ?? '-' }}"
                                                    readonly>
                                            </div>

                                            <div>
                                                <label class="font-semibold">Barang Bukti</label>
                                                <textarea class="border rounded-lg p-2 bg-gray-100 w-full" rows="2"
                                                    readonly>
{{ is_array($item->barang_bukti) ? implode(', ', $item->barang_bukti) : '-' }}
                </textarea>
                                            </div>

                                            <div>
                                                <label class="font-semibold">Hasil Tes Urine</label>
                                                <textarea class="border rounded-lg p-2 bg-gray-100 w-full" rows="2"
                                                    readonly>
{{ is_array($item->hasil_urine) ? implode(', ', $item->hasil_urine) : '-' }}
                </textarea>
                                            </div>

                                        </div>

                                        {{-- ================= KANAN ================= --}}
                                        <div class="space-y-3">

                                            <h4 class="font-semibold text-gray-700 border-b pb-1">
                                                Data Pemohon
                                            </h4>

                                            <div>
                                                <label class="font-semibold">Nama Lengkap</label>
                                                <input class="border rounded-lg p-2 bg-gray-100 w-full"
                                                    value="{{ $item->nama_lengkap }}" readonly>
                                            </div>

                                            <div>
                                                <label class="font-semibold">Alamat</label>
                                                <textarea class="border rounded-lg p-2 bg-gray-100 w-full" rows="2"
                                                    readonly>
{{ $item->alamat }}
                </textarea>
                                            </div>

                                            <div>
                                                <label class="font-semibold">Instansi</label>
                                                <input class="border rounded-lg p-2 bg-gray-100 w-full"
                                                    value="{{ $item->instansi }}" readonly>
                                            </div>

                                            <div>
                                                <label class="font-semibold">Nama Penyidik</label>
                                                <input class="border rounded-lg p-2 bg-gray-100 w-full"
                                                    value="{{ $item->nama_penyidik }}" readonly>
                                            </div>

                                            <div>
                                                <label class="font-semibold">WhatsApp Penyidik</label>
                                                <input class="border rounded-lg p-2 bg-gray-100 w-full"
                                                    value="{{ $item->wa_penyidik }}" readonly>
                                            </div>

                                            <div>
                                                <label class="font-semibold">Tanggal Surat Pengajuan</label>
                                                <input class="border rounded-lg p-2 bg-gray-100 w-full"
                                                    value="{{ \Carbon\Carbon::parse($item->tanggal_surat_pengajuan)->format('d-m-Y') }}"
                                                    readonly>
                                            </div>

                                            {{-- Surat Permohonan --}}
                                            @if($item->file_surat_permohonan)
                                                <div>
                                                    <label class="font-semibold mb-1 block">Surat Permohonan</label>
                                                    <div class="flex gap-3 items-center">
                                                        <input class="flex-1 border rounded-lg p-2 bg-gray-100"
                                                            value="{{ basename($item->file_surat_permohonan) }}"
                                                            readonly>

                                                        <a href="{{ asset('storage/'.$item->file_surat_permohonan) }}"
                                                            target="_blank"
                                                            class="bg-sky-500 hover:bg-sky-600 text-white px-3 py-2 rounded-md">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>

                                                        <a href="{{ asset('storage/'.$item->file_surat_permohonan) }}"
                                                            download
                                                            class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-2 rounded-md">
                                                            <i class="fa-solid fa-download"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif

                                            <div>
                                                <label class="font-semibold">Tanggal Laporan Polisi</label>
                                                <input class="border rounded-lg p-2 bg-gray-100 w-full"
                                                    value="{{ \Carbon\Carbon::parse($item->tanggal_lp)->format('d-m-Y') }}"
                                                    readonly>
                                            </div>

                                            {{-- LP --}}
                                            @if($item->file_lp)
                                                <div>
                                                    <label class="font-semibold mb-1 block">Laporan Polisi (LP)</label>
                                                    <div class="flex gap-3 items-center">
                                                        <input class="flex-1 border rounded-lg p-2 bg-gray-100"
                                                            value="{{ basename($item->file_lp) }}" readonly>

                                                        <a href="{{ asset('storage/'.$item->file_lp) }}"
                                                            target="_blank"
                                                            class="bg-sky-500 hover:bg-sky-600 text-white px-3 py-2 rounded-md">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>

                                                        <a href="{{ asset('storage/'.$item->file_lp) }}"
                                                            download
                                                            class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-2 rounded-md">
                                                            <i class="fa-solid fa-download"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif

                                            <div>
                                                <label class="font-semibold">Tanggal Penangkapan</label>
                                                <input class="border rounded-lg p-2 bg-gray-100 w-full"
                                                    value="{{ \Carbon\Carbon::parse($item->tanggal_penangkapan)->format('d-m-Y') }}"
                                                    readonly>
                                            </div>

                                            {{-- Penangkapan --}}
                                            @if($item->file_penangkapan)
                                                <div>
                                                    <label class="font-semibold mb-1 block">Berita Acara
                                                        Penangkapan</label>
                                                    <div class="flex gap-3 items-center">
                                                        <input class="flex-1 border rounded-lg p-2 bg-gray-100"
                                                            value="{{ basename($item->file_penangkapan) }}" readonly>

                                                        <a href="{{ asset('storage/'.$item->file_penangkapan) }}"
                                                            target="_blank"
                                                            class="bg-sky-500 hover:bg-sky-600 text-white px-3 py-2 rounded-md">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>

                                                        <a href="{{ asset('storage/'.$item->file_penangkapan) }}"
                                                            download
                                                            class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-2 rounded-md">
                                                            <i class="fa-solid fa-download"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                    {{-- FOOTER --}}
                                    <div class="mt-6 text-xs italic text-gray-600 border-t pt-3">
                                        Data yang diisikan dalam formulir ini benar dan menjadi tanggung jawab pemohon.
                                    </div>

                                </div>
                                {{-- ================= FOOTER ================= --}}
                                <div class="mt-6 flex justify-end">
                                    <button onclick="closeModal('modalDetail{{ $item->id }}')"
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                                        Tutup
                                    </button>
                                </div>

                            </div>
                        </div>
                        {{-- ================= END MODAL ================= --}}

                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-4">
                                Data belum tersedia.
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

{{-- SCRIPT --}}
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
