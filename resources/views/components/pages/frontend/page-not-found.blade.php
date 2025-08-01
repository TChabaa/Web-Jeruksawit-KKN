<x-Layouts.visitor-layout>
    <x-slot:title>404 - Halaman Tidak Ditemukan | </x-slot:title>
    <header>
        <x-partials.frontend.header />
    </header>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="text-center">
            <div class="mb-8">
                <h1 class="text-9xl font-bold text-gray-300">404</h1>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Halaman Tidak Ditemukan</h2>
                <p class="text-lg text-gray-600 mb-8">
                    Maaf, halaman yang Anda cari tidak dapat ditemukan.
                    Halaman mungkin telah dipindahkan, dihapus, atau URL yang dimasukkan salah.
                </p>
            </div>

            <div class="space-y-4 sm:space-y-0 sm:space-x-4 sm:flex sm:justify-center">
                <a href="{{ route('index') }}"
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    Kembali ke Beranda
                </a>

                <button onclick="history.back()"
                    class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Halaman Sebelumnya
                </button>
            </div>
        </div>

        <!-- Optional: Add some helpful links -->
        <div class="mt-16">
            <h3 class="text-xl font-semibold text-gray-800 text-center mb-8">Atau jelajahi halaman lainnya:</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <a href="{{ route('articles') }}"
                    class="block p-6 bg-white rounded-lg shadow hover:shadow-md transition duration-150 ease-in-out">
                    <h4 class="text-lg font-medium text-gray-900 mb-2">Artikel</h4>
                    <p class="text-gray-600">Baca artikel terbaru tentang desa wisata</p>
                </a>

                <a href="{{ route('destinations') }}"
                    class="block p-6 bg-white rounded-lg shadow hover:shadow-md transition duration-150 ease-in-out">
                    <h4 class="text-lg font-medium text-gray-900 mb-2">Destinasi</h4>
                    <p class="text-gray-600">Jelajahi tempat wisata menarik</p>
                </a>

                <a href="{{ route('events') }}"
                    class="block p-6 bg-white rounded-lg shadow hover:shadow-md transition duration-150 ease-in-out">
                    <h4 class="text-lg font-medium text-gray-900 mb-2">Acara</h4>
                    <p class="text-gray-600">Lihat acara dan kegiatan terbaru</p>
                </a>
            </div>
        </div>
    </section>
</x-Layouts.visitor-layout>
