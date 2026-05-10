@if ($paginator->hasPages())
    <div class="flex justify-between items-center mt-4 text-sm text-gray-600">
        {{-- Keterangan jumlah data --}}
        <div>
            Menampilkan 
            <span class="font-semibold">
                {{ ($paginator->firstItem() ?? 0) }} – {{ ($paginator->lastItem() ?? 0) }}
            </span> 
            dari 
            <span class="font-semibold">{{ $paginator->total() }}</span> data
        </div>

        {{-- Navigasi pagination --}}
        <nav role="navigation" aria-label="Pagination" class="flex">
            <ul class="join">
                {{-- Tombol Sebelumnya --}}
                @if ($paginator->onFirstPage())
                    <li>
                        <button class="join-item btn btn-sm bg-gray-200 text-gray-600 border border-gray-300 cursor-not-allowed">«</button>
                    </li>
                @else
                    <li>
                        <a href="{{ $paginator->previousPageUrl() }}" class="join-item btn btn-sm bg-gray-100 border border-gray-300 text-gray-700 hover:bg-gray-200">«</a>
                    </li>
                @endif

                {{-- Nomor Halaman --}}
                @foreach ($elements as $element)
                    {{-- Titik-titik --}}
                    @if (is_string($element))
                        <li>
                            <button class="join-item btn btn-sm bg-gray-100 text-gray-500 border border-gray-300">{{ $element }}</button>
                        </li>
                    @endif

                    {{-- Link Halaman --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                {{-- Halaman Aktif --}}
                                <li>
                                    <button class="join-item btn btn-sm bg-gray-300 text-black border border-gray-400 font-semibold">
                                        {{ $page }}
                                    </button>
                                </li>
                            @else
                                {{-- Halaman Lain --}}
                                <li>
                                    <a href="{{ $url }}" class="join-item btn btn-sm bg-gray-100 border border-gray-300 text-gray-700 hover:bg-gray-200">
                                        {{ $page }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Tombol Selanjutnya --}}
                @if ($paginator->hasMorePages())
                    <li>
                        <a href="{{ $paginator->nextPageUrl() }}" class="join-item btn btn-sm bg-gray-100 border border-gray-300 text-gray-700 hover:bg-gray-200">»</a>
                    </li>
                @else
                    <li>
                        <button class="join-item btn btn-sm bg-gray-200 text-gray-600 border border-gray-300 cursor-not-allowed">»</button>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif
