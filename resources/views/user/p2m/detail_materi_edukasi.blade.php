{{-- resources/views/user/p2m/detail_materi_edukasi.blade.php --}}
@extends('layout.user_bread')
@section('title', 'Materi Edukasi')

@section('content')
<div class="mt-10 px-6 md:px-20 pb-20 mt-[-90px]">

    {{-- JUDUL --}}
    <h4 class="text-center text-xl font-bold text-white">
        {{ $materi->judul }}
    </h4>

    <p class="text-center text-sm text-gray-200 mt-1">
        Oleh: <b>{{ $materi->user->name ?? 'Tidak diketahui' }}</b>
        |
        {{ \Carbon\Carbon::parse($materi->created_at)->translatedFormat('d F Y') }}
    </p>

    {{-- KONTEN UTAMA --}}
    <div class="flex justify-center mt-6">

        {{-- ================= VIDEO ================= --}}
        @if($materi->jenis === 'video')

            @if($materi->video_file)
                <video controls class="rounded-lg shadow-lg max-w-full md:max-w-lg mt-[-20px]">
                    <source src="{{ asset('storage/'.$materi->video_file) }}" type="video/mp4">
                    Browser kamu tidak mendukung video.
                </video>
            @elseif($materi->link_video)
                <iframe class="rounded-lg shadow-lg max-w-full md:max-w-lg mt-[-20px]" width="100%" height="400"
                    src="{{ $materi->link_video }}" frameborder="0" allowfullscreen>
                </iframe>
            @endif

            {{-- ================= INFOGRAFIS ================= --}}
        @elseif($materi->jenis === 'infografis')
            <img src="{{ asset('storage/'.$materi->gambar) }}"
                class="rounded-lg shadow-lg max-w-full md:max-w-lg mt-[-20px]" alt="Infografis">

            {{-- ================= ARTIKEL ================= --}}
        @elseif($materi->jenis === 'artikel')
            <img src="{{ asset('storage/'.$materi->gambar) }}"
                class="rounded-lg shadow-lg max-w-full md:max-w-lg mt-[-20px]" alt="Artikel">

            {{-- ================= MODUL ================= --}}
        @elseif($materi->jenis === 'modul')
            <iframe src="{{ asset('storage/'.$materi->file_modul) }}"
                class="rounded-lg shadow-lg w-full md:w-[800px] h-[500px] mt-[-20px]">
            </iframe>
        @endif

    </div>

    {{-- DESKRIPSI (DI BAWAH KONTEN) --}}
    <div class="mt-6 text-sm md:text-base leading-relaxed max-w-3xl mx-auto text-center">
        {!! nl2br(e($materi->deskripsi)) !!}
    </div>

</div>
@endsection
