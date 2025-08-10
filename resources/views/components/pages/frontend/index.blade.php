<x-Layouts.visitor-layout>
    <x-slot:title>Beranda</x-slot:title>
    <x-slot:pageTitle>Portal Resmi Desa Jeruksawit Karanganyar - Desa Wisata Terbaik</x-slot:pageTitle>
    <x-slot:metaDescription>Selamat datang di portal resmi Desa Jeruksawit, Karanganyar. Temukan pesona wisata desa, produk
        UMKM unggulan, layanan surat online, dan informasi terkini tentang desa wisata terbaik di Jawa Tengah.</x-slot:metaDescription>
    <x-slot:metaKeywords>desa jeruksawit, karanganyar, beranda, wisata desa, umkm jeruksawit, layanan surat online, desa
        wisata karanganyar, wisata jawa tengah, pemerintah desa jeruksawit</x-slot:metaKeywords>
    <x-slot:ogTitle>Beranda - Portal Resmi Desa Jeruksawit Karanganyar</x-slot:ogTitle>
    <x-slot:ogDescription>Portal resmi Desa Jeruksawit yang menyediakan informasi wisata, UMKM, layanan administrasi, dan
        berbagai fasilitas untuk masyarakat dan wisatawan.</x-slot:ogDescription>

    @push('structured-data')
        <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "Beranda Desa Jeruksawit",
        "description": "Portal resmi Desa Jeruksawit yang menyediakan informasi wisata, UMKM, layanan administrasi, dan berbagai fasilitas untuk masyarakat dan wisatawan.",
        "url": "{{ route('index') }}",
        "isPartOf": {
            "@type": "WebSite",
            "name": "Desa Jeruksawit",
            "url": "{{ url('/') }}"
        },
        "breadcrumb": {
            "@type": "BreadcrumbList",
            "itemListElement": [{
                "@type": "ListItem",
                "position": 1,
                "name": "Beranda",
                "item": "{{ route('index') }}"
            }]
        }
    }
    </script>
    @endpush

    <!-- Hero Section -->
    <header>
        <x-partials.frontend.hero />
    </header>

    <!-- Penjelasan Kegunaan Web -->
    <!-- Penjelasan Kegunaan Web -->
    <!-- Selamat Datang -->

    <!-- Informasi Tentang Desa Wisata -->
    <section class="relative px-3 md:px-0 mt-15 font-inter">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8 text-4xl font-extrabold text-center">
                <h2>Informasi dan Artikel Tentang Desa</h2>
            </div>
            <div class="flex flex-wrap justify-center gap-6">
                @forelse ($articles as $article)
                    <div class="w-full sm:w-1/2 lg:w-1/3 opacity-0 image-container transform translate-y-6">
                        <x-partials.frontend.card-article :article="$article" />
                    </div>
                @empty
                    <p class="text-xl font-semibold text-center text-gray-600">Belum ada artikel</p>
                @endforelse
            </div>
            <div class="mt-8 text-center">
                <a href="{{ route('articles') }}"
                    class="px-4 py-2 text-black transition-transform duration-300 transform border-2 border-gray-600 rounded-md hover:shadow-lg">
                    Lihat Semua
                </a>
            </div>
        </div>
    </section>

    <!-- Keunggulan -->
    <section class="mt-15">
        <x-partials.frontend.advantages-brand />
    </section>


    <section class="bg-gradient-to-r from-[#7F8D77] to-[#A2AF9B]">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 px-6 md:px-10 py-20">

            <!-- Bagian Teks -->
            <div class="space-y-8 text-white">
                <!-- Judul -->
                <h1 class="text-4xl md:text-5xl font-extrabold font-inter leading-tight">
                    Layanan Surat Menyurat Digital
                </h1>

                <!-- Deskripsi -->
                <p class="text-lg font-inter leading-relaxed">
                    Urus kebutuhan administrasi Anda tanpa ribet!
                    Melalui layanan <span class="font-semibold">Surat Menyurat Online</span>, Anda bisa mengajukan
                    berbagai jenis surat resmi
                    kapan saja dan di mana saja. Prosesnya mudah, cepat, dan transparan—tanpa perlu bolak-balik ke
                    kantor desa.
                    Semua data aman dan hasilnya dapat diunduh langsung setelah selesai.
                </p>

                <!-- Tombol -->
                <div>
                    <a href="{{ route('layanan-surat') }}"
                        class="inline-block px-6 py-3 text-lg font-semibold text-[#7F8D77] bg-white rounded-lg shadow-lg transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                        Ajukan Surat Sekarang
                    </a>
                </div>
            </div>

            <!-- Bagian Visual -->
            <div class="flex items-center justify-center text-white">
                <div class="text-center max-w-sm">
                    <!-- Ikon -->
                    <svg class="w-32 h-32 mx-auto mb-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                    </svg>

                    <!-- Subjudul -->
                    <h3 class="text-2xl font-bold mb-2">
                        Mudah, Cepat, & Aman
                    </h3>

                    <!-- Keterangan -->
                    <p class="text-lg opacity-90 leading-relaxed">
                        Semua pengajuan surat dilakukan secara online
                        dengan sistem terintegrasi yang mempermudah proses.
                    </p>
                </div>
            </div>
        </div>
    </section>


    <!-- Tempat Wisata -->
    <section class="mt-15 font-inter">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8 text-4xl font-extrabold text-center">
                <h1>Tempat Wisata</h1>
            </div>
            <div class="flex flex-wrap justify-center gap-6">
                @forelse ($destinations as $destination)
                    <div class="w-full sm:w-1/2 lg:w-1/3 card-container">
                        <x-partials.frontend.card-destination :$destination />
                    </div>
                @empty
                    <p class="font-semibold text-center text-gray-500">Belum ada tempat wisata</p>
                @endforelse
            </div>
            <div class="mt-8 text-center">
                <a href="{{ route('destinations') }}"
                    class="px-4 py-2 text-black transition-transform duration-300 transform border-2 border-gray-600 rounded-md hover:shadow-lg">
                    Lihat Semua
                </a>
            </div>
        </div>
    </section>

    <!-- UMKM -->
    <section class="mt-15 font-inter">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8 text-4xl font-extrabold text-center">
                <h1>UMKM Desa</h1>
            </div>
            <div class="flex flex-wrap justify-center gap-6">
                @forelse ($umkms as $umkm)
                    <div class="w-full sm:w-1/2 lg:w-1/3 card-container">
                        <x-partials.frontend.card-umkm :$umkm />
                    </div>
                @empty
                    <p class="font-semibold text-center text-gray-500">Belum ada UMKM</p>
                @endforelse
            </div>
            <div class="mt-8 text-center">
                <a href="{{ route('umkm') }}"
                    class="px-4 py-2 text-black transition-transform duration-300 transform border-2 border-gray-600 rounded-md hover:shadow-lg">
                    Lihat Semua
                </a>
            </div>
        </div>
    </section>

    <!-- Perangkat Desa Carousel -->
    <section class="bg-gray-50 py-16 mt-15 font-inter">
        <div class="max-w-7xl mx-auto px-4">
            <div class="mb-12 text-center">
                <h2 class="text-4xl font-extrabold text-gray-900 mb-4">Perangkat Desa Jeruksawit</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Berkenalan dengan perangkat desa yang berkomitmen melayani masyarakat Desa Jeruksawit dengan
                    dedikasi tinggi
                </p>
            </div>

            @if ($perangkatDesas->count() > 0)
                <div class="relative pb-6">
                    <div class="overflow-hidden">
                        <div class="flex transition-transform duration-300 ease-in-out" id="perangkatCarousel">
                            @foreach ($perangkatDesas as $perangkatDesa)
                                <div class="w-full md:w-1/2 lg:w-1/3 xl:w-1/4 flex-shrink-0 px-3">
                                    <x-partials.frontend.card-perangkat-desa :$perangkatDesa />
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if ($perangkatDesas->count() > 4)
                        <button
                            class="absolute left-0 top-1/2 -translate-y-1/2 bg-white rounded-full p-2 shadow-lg hover:bg-gray-50 transition-colors z-10"
                            onclick="slideCarousel(-1)">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button
                            class="absolute right-0 top-1/2 -translate-y-1/2 bg-white rounded-full p-2 shadow-lg hover:bg-gray-50 transition-colors z-10"
                            onclick="slideCarousel(1)">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>
                    @endif
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg">Belum ada data perangkat desa</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/ScrollTrigger.min.js"></script>
    <script>
        let currentSlide = 0;
        const totalSlides = {{ $perangkatDesas->count() }};
        const itemsPerView = 4;

        function slideCarousel(direction) {
            const carousel = document.getElementById('perangkatCarousel');
            const maxSlide = Math.max(0, totalSlides - itemsPerView);

            currentSlide += direction;
            if (currentSlide < 0) currentSlide = 0;
            else if (currentSlide > maxSlide) currentSlide = maxSlide;

            const translateX = -currentSlide * (100 / itemsPerView);
            carousel.style.transform = `translateX(${translateX}%)`;
        }

        document.addEventListener('DOMContentLoaded', function() {
            gsap.registerPlugin(ScrollTrigger);

            gsap.utils.toArray('.image-container').forEach(container => {
                gsap.to(container, {
                    scrollTrigger: {
                        trigger: container,
                        start: 'top 80%',
                        end: 'top 30%',
                        toggleActions: 'play none none reverse',
                    },
                    opacity: 1,
                    y: 0,
                    duration: 1
                });
            });
        });
    </script>
</x-Layouts.visitor-layout>
