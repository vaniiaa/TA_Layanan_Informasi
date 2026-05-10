{{-- resources/views/p2m/profile.blade.php --}}
@extends('layout.p2m')
@section('title', 'Profile')

@section('content')
<div class="flex justify-center mt-8">
    <div class="bg-white w-full max-w-4xl rounded-xl shadow-md border border-gray-200 p-6">

        <div class="border-b border-gray-300 pb-2 mb-4">
            <h2 class="text-xl font-semibold text-gray-700">Profile</h2>
        </div>

        @if(session('success'))
            <div class="mb-4 text-green-600 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('p2m.profile.update') }}" method="POST">
            @csrf

            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">

                {{-- Avatar Profil --}}
                <div class="flex-shrink-0 flex flex-col items-center">
                    <div class="w-28 h-28 rounded-full bg-gray-200 
                flex items-center justify-center mb-3 mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.118a7.5 7.5 0 0115 0" />
                        </svg>
                    </div>
                </div>

                {{-- Data --}}
                <div class="flex-1 grid grid-cols-1 gap-3 w-full">

                    <div>
                        <label class="text-sm text-gray-600">Nama</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" disabled
                            class="profile-input w-full border rounded-md px-2 py-1 text-sm bg-gray-100">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Email</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" disabled
                            class="profile-input w-full border rounded-md px-2 py-1 text-sm bg-gray-100">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Password (baru)</label>
                        <input type="password" name="password" disabled
                            class="profile-input w-full border rounded-md px-2 py-1 text-sm bg-gray-100">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" disabled
                            class="profile-input w-full border rounded-md px-2 py-1 text-sm bg-gray-100">
                    </div>

                </div>
            </div>

            {{-- Tombol --}}
            <div class="mt-6 text-right">
                <button type="button" id="editBtn" onclick="enableEdit()"
                    class="bg-blue-600 text-white px-4 py-1.5 rounded-md text-sm hover:bg-blue-700 transition">
                    Ubah
                </button>

                <button type="submit" id="saveBtn"
                    class="hidden bg-green-600 text-white px-4 py-1.5 rounded-md text-sm hover:bg-green-700 transition">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

{{-- Script --}}
<script>
    function enableEdit() {
        document.querySelectorAll('.profile-input').forEach(input => {
            input.disabled = false;
            input.classList.remove('bg-gray-100');
        });

        document.getElementById('editBtn').classList.add('hidden');
        document.getElementById('saveBtn').classList.remove('hidden');
    }

</script>
@endsection
