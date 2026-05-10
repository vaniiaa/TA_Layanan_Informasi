{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layout.admin')
@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen p-6 bg-gradient-to-b from-gray-50 via-white to-gray-50">

    {{-- HEADER --}}
    <h1 class="text-2xl font-bold text-gray-800 mb-8 tracking-wide 
    border-b border-gray-200 pb-4">
        ADMIN DASHBOARD
    </h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

        {{-- SOSIALISASI --}}
        <div class="relative bg-white border border-gray-200 rounded-2xl shadow-sm p-6
        hover:shadow-lg hover:-translate-y-1 transition">

            <!-- Garis samping -->
            <div class="absolute left-0 top-0 h-full w-1 bg-rose-500 rounded-l-2xl"></div>

            <!-- Icon -->
            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-rose-100 text-rose-600 mb-3">
                <i class="fa-solid fa-bullhorn"></i>
            </div>

            <h2 class="text-sm font-medium text-gray-500">Sosialisasi Narkoba</h2>

            <p class="counter text-3xl font-bold text-gray-900 mt-1" data-target="{{ $totalSosialisasi ?? 0 }}">
                0</p>
        </div>


        {{-- Wisata Edukasi --}}
        <div class="relative bg-white border border-gray-200 rounded-2xl shadow-sm p-6
        hover:shadow-lg hover:-translate-y-1 transition">

            <div class="absolute left-0 top-0 h-full w-1 bg-sky-500 rounded-l-2xl"></div>

            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-sky-100 text-sky-600 mb-3">
                <i class="fa-solid fa-book-open"></i>
            </div>

            <h2 class="text-sm font-medium text-gray-500">Wisata Edukasi</h2>

            <p class="counter text-3xl font-bold text-gray-900 mt-1" data-target="{{ $totalDoemba ?? 0 }}">0</p>
        </div>


        {{-- BESUK --}}
        <div class="relative bg-white border border-gray-200 rounded-2xl shadow-sm p-6
        hover:shadow-lg hover:-translate-y-1 transition">

            <div class="absolute left-0 top-0 h-full w-1 bg-emerald-500 rounded-l-2xl"></div>

            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-emerald-100 text-emerald-600 mb-3">
                <i class="fa-solid fa-user-group"></i>
            </div>

            <h2 class="text-sm font-medium text-gray-500">Besuk Tahanan</h2>

            <p class="counter text-3xl font-bold text-gray-900 mt-1"
                data-target="{{ $totalBesukTahanan ?? 0 }}">0</p>
        </div>


        {{-- TAT --}}
        <div class="relative bg-white border border-gray-200 rounded-2xl shadow-sm p-6
        hover:shadow-lg hover:-translate-y-1 transition">

            <div class="absolute left-0 top-0 h-full w-1 bg-amber-500 rounded-l-2xl"></div>

            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-amber-100 text-amber-600 mb-3">
                <i class="fa-solid fa-clipboard-check"></i>
            </div>

            <h2 class="text-sm font-medium text-gray-500">TAT</h2>

            <p class="counter text-3xl font-bold text-gray-900 mt-1"
                data-target="{{ $totalPendaftaranTAT ?? 0 }}">0</p>
        </div>

    </div>

    {{-- RIWAYAT --}}
    <div class="bg-white/80 backdrop-blur border border-gray-200 p-6 rounded-2xl shadow-sm">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-gray-800">
                Riwayat Pendaftaran
            </h2>

            <span class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full">
                Terbaru
            </span>
        </div>

        @if(!empty($riwayatPendaftaran) && $riwayatPendaftaran->count() > 0)

            <div class="space-y-4">

                @foreach($riwayatPendaftaran as $item)
                    <div class="flex items-center justify-between p-4 rounded-xl 
                    bg-white border border-gray-100 shadow-sm hover:shadow-md transition">

                        <div class="flex items-center gap-3">

                            <div class="w-11 h-11 flex items-center justify-center rounded-full 
                            bg-gradient-to-br from-indigo-500 to-blue-500 text-white font-bold">
                                {{ strtoupper(substr($item->nama_pemohon, 0, 1)) }}
                            </div>

                            <div>
                                <p class="font-semibold text-gray-800">
                                    {{ $item->jenis_pendaftaran }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ $item->nama_pemohon }}
                                </p>
                            </div>
                        </div>

                        <div class="text-right text-xs text-gray-500">
                            <p>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                            </p>
                            <p>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</p>
                        </div>

                    </div>
                @endforeach

            </div>

        @else
            <div class="text-center text-gray-400 py-10">
                <p class="font-medium">Belum ada data</p>
            </div>
        @endif

    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const counters = document.querySelectorAll('.counter');

        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target')) || 0;

            let count = 0;
            const speed = 40;

            const update = () => {
                const increment = Math.ceil(target / speed);

                if (count < target) {
                    count += increment;
                    counter.innerText = count > target ? target : count;
                    requestAnimationFrame(update);
                } else {
                    counter.innerText = target;
                }
            };

            update();
        });
    });

</script>

@endsection
