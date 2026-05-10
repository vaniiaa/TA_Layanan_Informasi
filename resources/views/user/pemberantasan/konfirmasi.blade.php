{{-- resources/views/user/pemberantasan/konfirmasi.blade.php --}}
@extends('layout.user_bread')
@section('title', 'Konfirmasi Pendaftaran')

@section('content')
<div class="container mx-auto px-4 pt-32 pb-12 relative">
    <div class="bg-white rounded-xl shadow-md border border-[#022D57] p-6
        w-full md:w-3/4 lg:w-3/4 mx-auto mt-[-200px] text-center">
        <h2 class="text-lg font-bold text-gray-800 mb-3">Pendaftaran Berhasil</h2>

        <p class="text-gray-700 text-sm leading-relaxed mb-4">
            Nama : {{ session('nama_pembesuk') }} <br>
            Tanggal Pendaftaran : {{ session('tanggal_pendaftaran') }}
        </p>

        <p class="font-semibold">Terima kasih telah melakukan pendaftaran.<br>
            Silakan unduh bukti pendaftaran di bawah ini.</p>
    </div>

    <div class="flex justify-center pt-10 gap-4">
        <a href="{{ route('besuk.downloadBukti') }}"
            class="bg-[#022D57] hover:bg-[#034077] transition text-white px-6 py-2 rounded-md">
            Unduh Bukti
        </a>

        <a href="{{ url('/') }}"
            class="bg-[#022D57] hover:bg-[#034077] transition text-white px-6 py-2 rounded-md">
            Kembali
        </a>
    </div>
</div>
@endsection