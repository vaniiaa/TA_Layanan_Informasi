{{-- resources/views/user/pemberantasan/publikasi_berita.blade.php --}}
@extends('layout.user_bread')
@section('title', 'Publikasi Berita')

@section('content')

<div class="mt-10 px-6 md:px-20 pb-20 mt-[-70px]">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach($publikasi as $item)

            <a href="{{ route('user.pemberantasan.detail_publikasi_berita', $item->id) }}"
                class="
            bg-white rounded-lg overflow-hidden
            shadow-md
            transition-all duration-300 ease-in-out
            transform
            hover:-translate-y-2
            hover:scale-[1.03]
            hover:shadow-2xl
   
        ">
                {{-- GAMBAR / THUMBNAIL --}}
                @if($item->gambar)
                    <img src="{{ asset('image/frame.png') }}" class="w-full h-40 object-cover">
                @endif

                <div class="p-5 flex flex-col h-full">

                    <p class="text-sm font-semibold text-blue-600">
                        {{ ucfirst($item->jenis) }}
                    </p>

                    <h3 class="text-lg font-bold mt-1">
                        {{ $item->judul }}
                    </h3>

                    <p class="mt-2 text-sm text-gray-600">
                        {{ Str::limit($item->deskripsi, 100) }}
                    </p>

                </div>

            </a>

        @endforeach

        @if($publikasi->count() == 0)
            <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center text-gray-500">
                Belum ada materi edukasi.
            </div>
        @endif

    </div>
</div>

@endsection