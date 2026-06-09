{{-- resources/views/dashboard.blade.php --}}
@extends('layout.user')

@section('content')

{{-- ================= CAROUSEL ================= --}}
<div class="carousel w-full">
    <div id="slide1" class="carousel-item relative w-full">
        <img src="{{ asset('image/carousel 1.png') }}" class="w-full" />
        <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
            <a href="#slide3" class="btn btn-circle">❮</a>
            <a href="#slide2" class="btn btn-circle">❯</a>
        </div>
    </div>

    <div id="slide2" class="carousel-item relative w-full">
        <img src="{{ asset('image/carousel 2.png') }}" class="w-full" />
        <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
            <a href="#slide1" class="btn btn-circle">❮</a>
            <a href="#slide3" class="btn btn-circle">❯</a>
        </div>
    </div>

    <div id="slide3" class="carousel-item relative w-full">
        <img src="{{ asset('image/carousel 3.png') }}" class="w-full" />
        <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
            <a href="#slide2" class="btn btn-circle">❮</a>
            <a href="#slide1" class="btn btn-circle">❯</a>
        </div>
    </div>
</div>

{{-- ================= SELAMAT DATANG ================= --}}
<div class="flex flex-col md:flex-row items-center gap-10 mt-10 px-6 md:px-20">

    <!-- TEXT -->
    <div class="flex-1">
        <h2 class="text-3xl font-bold text-[#022D57] leading-snug">
            Selamat Datang di Dashboard SILOFI <br>
            <span class="text-blue-500">Sistem Layanan Informasi BNNP Kepri</span>
        </h2>

        <p class="mt-4 text-gray-600 leading-relaxed">
            Dashboard ini dirancang untuk memudahkan pengguna dalam mengakses layanan dari bidang
            <b>Pencegahan & Pemberdayaan Masyarakat</b>, <b>Pemberantasan</b>.
            Anda dapat melakukan pendaftaran layanan serta memantau berbagai kegiatan secara cepat dan terintegrasi.
        </p>
        <a href="#layanan"
            class="inline-block mt-6 bg-[#022D57] hover:bg-blue-800 text-white px-5 py-2 rounded-lg shadow">
            Jelajahi Layanan
        </a>
    </div>

    <!-- IMAGE -->
    <div class="w-full md:w-1/3">
        <img src="{{ asset('image/asset.png') }}" class="rounded-xl shadow-lg">
    </div>

</div>
<div class="mt-20 px-6 md:px-20 text-center">
    <h2 class="text-3xl font-bold inline-block relative pb-3 text-[#022D57]">
        Bidang BNNP Kepri
        <span class="absolute left-0 bottom-0 w-full h-1 bg-[#022D57] rounded-full"></span>
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mt-12">

        <!-- P2M -->
        <div class="bg-white rounded-xl shadow-md p-8 hover:shadow-xl transition">

            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full text-xl">
                    🎓
                </div>
                <h3 class="text-xl font-bold text-[#022D57]">
                    Pencegahan & Pemberdayaan Masyarakat (P2M)
                </h3>
            </div>

            <p class="text-gray-600 leading-relaxed">
                Bidang P2M berfokus pada upaya pencegahan penyalahgunaan narkoba melalui
                kegiatan edukasi, sosialisasi, serta pemberdayaan masyarakat.
                Program ini bertujuan meningkatkan kesadaran masyarakat agar mampu
                menolak dan melawan penyalahgunaan narkotika sejak dini.
            </p>

        </div>

        <!-- PEMBERANTASAN -->
        <div class="bg-white rounded-xl shadow-md p-8 hover:shadow-xl transition">

            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 flex items-center justify-center bg-red-100 text-red-600 rounded-full text-xl">
                    🚔
                </div>
                <h3 class="text-xl font-bold text-[#022D57]">
                    Pemberantasan
                </h3>
            </div>

            <p class="text-gray-600 leading-relaxed">
                Bidang Pemberantasan bertugas melakukan penindakan terhadap peredaran gelap narkoba,
                termasuk operasi penangkapan, penyelidikan, dan kerja sama dengan aparat penegak hukum.
                Tujuannya adalah menciptakan lingkungan yang aman dan bebas dari narkotika.
            </p>

        </div>

    </div>

</div>
{{-- ================= JUDUL LAYANAN ================= --}}
<div id="layanan" class="text-center mt-16">
    <h2 class="text-3xl font-bold inline-block relative pb-3">
        Layanan
        <span class="absolute left-0 bottom-0 w-full h-1 bg-[#022D57] rounded-full"></span>
    </h2>
</div>

{{-- ================= CARD LAYANAN (6) ================= --}}
<div class="mt-12 px-6 md:px-20">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

        @php
            $layanan = [
            [
            'judul' => 'Permohonan Sosialisasi',
            'desc' => 'Pengajuan kegiatan sosialisasi narkoba',
            'url' => url('/user/p2m/sosialisasi_narkoba')
            ],
            [
            'judul' => 'Wisata Edukasi',
            'desc' => 'Kunjungan edukatif ke BNN',
            'url' => url('/user/p2m/wisata_edukasi')
            ],
            [
            'judul' => 'Materi Edukasi',
            'desc' => 'Akses materi edukasi narkoba',
            'url' => url('/user/p2m/materi_edukasi')
            ],
            [
            'judul' => 'Permohonan TAT',
            'desc' => 'Pengajuan assessment terpadu',
            'url' => url('/user/pemberantasan/assessment_terpadu')
            ],
            [
            'judul' => 'Besuk Tahanan',
            'desc' => 'Pengajuan kunjungan tahanan',
            'url' => url('/user/pemberantasan/besuk_tahanan')
            ],
            [
            'judul' => 'Publikasi Berita',
            'desc' => 'Informasi berita dan kegiatan BNN',
            'url' => url('/user/pemberantasan/publikasi_berita')
            ],
            ];
        @endphp
        @foreach($layanan as $item)
            <a href="{{ $item['url'] }}" class="block">
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition duration-300 p-6 group">

                    <div class="mb-4">
                        <div
                            class="w-12 h-12 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full text-xl">
                            📌
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold text-[#022D57] group-hover:text-blue-600">
                        {{ $item['judul'] }}
                    </h3>

                    <p class="mt-2 text-gray-600 text-sm">
                        {{ $item['desc'] }}
                    </p>

                    <button class="mt-4 text-blue-500 text-sm hover:underline">
                        Akses Layanan →
                    </button>

                </div>
</a>
        @endforeach

    </div>
</div>

{{-- ================= GALERI KEGIATAN ================= --}}
<div class="mt-20 px-6 md:px-20 text-center">
    <h2 class="text-3xl font-bold inline-block relative pb-3 text-[#022D57]">
        Dokumentasi Kegiatan
        <span class="absolute left-0 bottom-0 w-full h-1 bg-[#022D57] rounded-full"></span>
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-12">

        <!-- ITEM -->
        <div class="h-56 overflow-hidden rounded-xl shadow-md">
            <img src="{{ asset('image/giat/p2m_doemba (5).jpg') }}"
                class="w-full h-full object-cover hover:scale-105 transition">
        </div>

        <div class="h-56 overflow-hidden rounded-xl shadow-md">
            <img src="{{ asset('image/giat/p2m_sosialisasi (5).jpg') }}"
                class="w-full h-full object-cover hover:scale-105 transition">
        </div>

        <div class="h-56 overflow-hidden rounded-xl shadow-md">
            <img src="{{ asset('image/giat/pemberantasan_besuk (1).jpeg') }}"
                class="w-full h-full object-cover hover:scale-105 transition">
        </div>

        <div class="h-56 overflow-hidden rounded-xl shadow-md">
            <img src="{{ asset('image/giat/pemberantasan_besuk (4).jpeg') }}"
                class="w-full h-full object-cover hover:scale-105 transition">
        </div>

        <div class="h-56 overflow-hidden rounded-xl shadow-md">
            <img src="{{ asset('image/giat/pemberantasan_tat (3).jpeg') }}"
                class="w-full h-full object-cover hover:scale-105 transition">
        </div>

        <div class="h-56 overflow-hidden rounded-xl shadow-md">
            <img src="{{ asset('image/giat/p2m_doemba (6).jpg') }}"
                class="w-full h-full object-cover hover:scale-105 transition">
        </div>

    </div>

</div>
<br>
<br>

{{-- ================= AUTO SLIDE ================= --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const slides = ["slide1", "slide2", "slide3"];
        let index = 0;

        setInterval(() => {
            index = (index + 1) % slides.length;

            const scrollPos = window.scrollY;
            document.getElementById(slides[index]).scrollIntoView({
                behavior: "smooth",
                block: "nearest"
            });
            window.scrollTo(0, scrollPos);
        }, 3000);
    });

</script>

<style>
    html {
        scroll-behavior: smooth;
    }

</style>
@endsection
