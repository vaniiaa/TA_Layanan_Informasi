{{-- resources/views/user/pemberantasan/detail_publikasi_berita.blade.php --}}
@extends('layout.user_bread')
@section('title', 'Publikasi Berita')

@section('content')
<div class="mt-10 px-6 md:px-20 pb-20 mt-[-90px]">

    {{-- JUDUL --}}
    <h4 class="text-center text-xl font-bold text-white">
        {{ $publikasi->judul }}
    </h4>

    {{-- AUTHOR + TANGGAL --}}
    <p class="text-center text-sm text-gray-200 mt-2">
        Oleh: <b>{{ $publikasi->user->name ?? 'Admin' }}</b>
        |
        {{ \Carbon\Carbon::parse($publikasi->created_at)->translatedFormat('d F Y') }}
    </p>

    {{-- KONTEN UTAMA --}}
    <div class="flex justify-center mt-6">

        {{-- ================= GAMBAR BERITA ================= --}}
        @if($publikasi->gambar)
            <img src="{{ asset('storage/'.$publikasi->gambar) }}"
                class="rounded-lg shadow-lg max-w-full md:max-w-lg mt-[-20px]" alt="Publikasi Berita">
        @else
            <img src="{{ asset('image/frame.png') }}"
                class="rounded-lg shadow-lg max-w-full md:max-w-lg mt-[-20px]" alt="Publikasi Berita">
        @endif

    </div>

    {{-- DESKRIPSI (DI BAWAH GAMBAR) --}}
    <div class="mt-6 text-sm md:text-base leading-relaxed max-w-3xl mx-auto text-center">
        {!! nl2br(e($publikasi->deskripsi)) !!}
    </div>

</div>
@endsection
