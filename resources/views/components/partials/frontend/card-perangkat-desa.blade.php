<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    @if ($perangkatDesa->gambar)
        <img class="w-full h-48 object-cover" src="{{ Storage::url($perangkatDesa->gambar) }}"
            alt="Foto {{ $perangkatDesa->nama }}">
    @else
        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
        </div>
    @endif

    <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $perangkatDesa->nama }}</h3>
        <p class="text-green-new font-medium">{{ $perangkatDesa->jabatan }}</p>
    </div>
</div>
