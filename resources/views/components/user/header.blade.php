<div class="sticky top-0 z-50 bg-white shadow-sm w-full">
  <div class="flex items-center justify-between px-4 sm:px-6 py-3">

    {{-- LOGO --}}
    <div class="flex items-center gap-3">
      <img src="{{ asset('image/logo BNN.png') }}" class="h-9 w-9 sm:h-10 sm:w-10 object-contain">
      <span class="font-bold text-lg sm:text-xl text-[#022D57]">SILOFI</span>
    </div>

    {{-- ================= DESKTOP MENU ================= --}}
    <ul class="hidden md:flex items-center gap-5 lg:gap-6 font-medium text-sm lg:text-base text-[#022D57]">

      <li>
        <a href="{{ url('/') }}" class="hover:text-blue-700 transition">
          BERANDA
        </a>
      </li>

     
    <li class="relative group max-w-[260px]">
  <span class="cursor-pointer hover:text-blue-700 transition whitespace-nowrap text-sm lg:text-base">
    P2M
  </span>

  <ul class="absolute top-full left-0 mt-2 w-64 bg-white shadow-lg rounded-md
             opacity-0 invisible group-hover:opacity-100 group-hover:visible
             translate-y-2 group-hover:translate-y-0
             transition-all duration-200">
    <li>
      <a href="{{ url('/user/p2m/sosialisasi_narkoba') }}" class="block px-4 py-2 hover:bg-gray-100">
        Sosialisasi
      </a>
    </li>
    <li>
      <a href="{{ url('/user/p2m/wisata_edukasi') }}" class="block px-4 py-2 hover:bg-gray-100">
        Wisata Edukasi
      </a>
    </li>
    <li>
      <a href="{{ url('/user/p2m/materi_edukasi') }}" class="block px-4 py-2 hover:bg-gray-100">
        Materi Edukasi
      </a>
    </li>
  </ul>
</li>


      {{-- PEMBERANTASAN --}}
      <li class="relative group">
        <span class="cursor-pointer hover:text-blue-700 transition">
          PEMBERANTASAN
        </span>
        <ul class="absolute top-full left-0 mt-2 w-64 bg-white shadow-lg rounded-md
                   opacity-0 invisible group-hover:opacity-100 group-hover:visible
                   translate-y-2 group-hover:translate-y-0
                   transition-all duration-200">
          <li><a href="{{ url('/user/pemberantasan/publikasi_berita') }}" class="block px-4 py-2 hover:bg-gray-100">Publikasi Berita</a></li>
          
          <li><a href="{{ url('/user/pemberantasan/besuk_tahanan') }}" class="block px-4 py-2 hover:bg-gray-100">Besuk Tahanan</a></li>
          <li><a href="{{ url('/user/pemberantasan/assessment_terpadu') }}" class="block px-4 py-2 hover:bg-gray-100">Assessment TAT</a></li>
        </ul>
      </li>

     

    </ul>

    {{-- ================= MOBILE NAVBAR ================= --}}
    <div class="md:hidden dropdown dropdown-end">
      <label tabindex="0" class="btn btn-ghost text-2xl">☰</label>

      <ul tabindex="0"
          class="menu menu-sm dropdown-content mt-3 p-4 shadow-lg bg-white rounded-lg w-72 text-[#022D57]">

        <li><a href="{{ url('/') }}">BERANDA</a></li>

      

        <li>
          <details>
            <summary>P2M</summary>
            <ul>
              <li><a href="{{ url('/user/p2m/sosialisasi_narkoba') }}">Sosialisasi</a></li>
              <li><a href="{{ url('/user/p2m/wisata_edukasi') }}">Wisata Edukasi</a></li>
              <li><a href="{{ url('/user/p2m/materi_edukasi') }}">Materi Edukasi</a></li>
            </ul>
          </details>
        </li>

        <li>
          <details>
            <summary>PEMBERANTASAN</summary>
            <ul>
              <li><a href="{{ url('/user/pemberantasan/publikasi_berita') }}">Publikasi Berita</a></li>
              
              <li><a href="{{ url('/user/pemberantasan/besuk_tahanan') }}">Besuk Tahanan</a></li>
              <li><a href="{{ url('/user/pemberantasan/assessment_terpadu') }}">Assessment TAT</a></li>
            </ul>
          </details>
        </li>

      

      </ul>
    </div>

  </div>
</div>
