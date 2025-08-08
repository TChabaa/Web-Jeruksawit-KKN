<x-Layouts.visitor-layout>
    <x-slot:title>Beranda | </x-slot:title>
    <header>
        <x-partials.frontend.hero />
    </header>

    <section class="font-inter">
        <div class="mb-8 text-4xl font-extrabold text-center">
            <h1 class="font-inter">Tempat Wisata</h1>
        </div>
        <div class="flex flex-wrap items-center justify-center gap-4 px-4 md:px-0">
            @forelse ($destinations as $destination)
                <div class="card-container">
                    <x-partials.frontend.card-destination :$destination />
                </div>
            @empty
                <p class="font-semibold text-center text-gray-500">Belum ada tempat wisata</p>
            @endforelse
        </div>
        <div class="mt-10 text-center">
            <a href="{{ route('destinations') }}"
                class="px-4 py-2 text-black transition-transform duration-300 transform border-2 border-gray-600 rounded-md hover:shadow-lg ">Lihat
                Semua</a>
        </div>
    </section>

    <section class="">
        <x-partials.frontend.advantages-brand />
    </section>

    <!-- Perangkat Desa Carousel Section -->
    <section class="bg-gray-50 py-16 font-inter">
        <div class="max-w-7xl mx-auto px-4">
            <div class="mb-12 text-center">
                <h2 class="text-4xl font-extrabold text-gray-900 mb-4">Perangkat Desa Jeruksawit</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Berkenalan dengan perangkat desa yang berkomitmen melayani masyarakat Desa Jeruksawit dengan
                    dedikasi tinggi
                </p>
            </div>

            @if ($perangkatDesas->count() > 0)
                <div class="relative">
                    <!-- Carousel container -->
                    <div class="overflow-hidden">
                        <div class="flex transition-transform duration-300 ease-in-out" id="perangkatCarousel">
                            @foreach ($perangkatDesas as $index => $perangkatDesa)
                                <div class="w-full md:w-1/2 lg:w-1/3 xl:w-1/4 flex-shrink-0 px-3">
                                    <x-partials.frontend.card-perangkat-desa :$perangkatDesa />
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Navigation buttons -->
                    @if ($perangkatDesas->count() > 4)
                        <button
                            class="absolute left-0 top-1/2 -translate-y-1/2 bg-white rounded-full p-2 shadow-lg hover:bg-gray-50 transition-colors"
                            onclick="slideCarousel(-1)">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button
                            class="absolute right-0 top-1/2 -translate-y-1/2 bg-white rounded-full p-2 shadow-lg hover:bg-gray-50 transition-colors"
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

    <section class="font-inter">
        <div class="mb-8 text-4xl font-extrabold text-center">
            <h1 class="font-inter">UMKM Desa Wisata</h1>
        </div>
        <div class="flex flex-wrap items-center justify-center gap-4 px-4 md:px-0">
            @forelse ($umkms as $umkm)
                <div class="card-container">
                    <x-partials.frontend.card-umkm :$umkm />
                </div>
            @empty
                <p class="font-semibold text-center text-gray-500">Belum ada UMKM</p>
            @endforelse
        </div>
        <div class="mt-10 text-center">
            <a href="{{ route('umkm') }}"
                class="px-4 py-2 text-black transition-transform duration-300 transform border-2 border-gray-600 rounded-md hover:shadow-lg ">Lihat
                Semua</a>
        </div>
    </section>

    <section class="bg-[#A2AF9B]">
        <div class="grid py-20 mx-auto md:grid-cols-2 max-w-7xl">
            <div class="pl-10 mb-8 space-y-10 text-white text-balance ">
                <h1 class="text-4xl font-extrabold font-inter">Layanan Surat Menyurat</h1>
                <p class="w-3/4 font-inter">
                    Dapatkan berbagai layanan pembuatan surat menyurat secara online dengan mudah dan cepat.
                    Kami menyediakan layanan SKCK, Surat Izin Keramaian, Surat Keterangan Usaha, SKTM,
                    dan berbagai jenis surat lainnya untuk memenuhi kebutuhan administrasi Anda.
                    Proses pengajuan yang mudah dan hasil yang dapat diandalkan.
                </p>
                <div class="mt-6">
                    <a href="{{ route('layanan-surat') }}"
                        class="px-4 py-2 transition-transform duration-300 transform border-2 border-white rounded-md font-inter hover:shadow-lg">Ajukan
                        Surat</a>
                </div>
            </div>
            <div class="flex items-center justify-center">
                <div class="text-center text-white">
                    <svg class="w-32 h-32 mx-auto mb-4" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                    </svg>
                    <h3 class="text-2xl font-bold mb-2">Layanan Digital</h3>
                    <p class="text-lg">Proses surat menyurat yang cepat dan efisien</p>
                </div>
            </div>
        </div>
    </section>

    <section class="relative">
        <div class="">

            <x-partials.frontend.logo />

        </div>

    </section>
    <section class="relative px-3 md:px-0 mt-29">
        <div class="mb-8 text-4xl font-extrabold text-center">
            <h1 class="font-inter">Informasi Tentang Desa Wisata</h1>
        </div>
        <div class="flex flex-wrap items-center justify-center gap-4 py-4">
            @forelse ($articles as $article)
                <div class="opacity-0 image-container">
                    <x-partials.frontend.card-article :article="$article" />
                </div>
            @empty
                <p class="text-xl font-semibold text-center text-gray-600">Belum ada artikel</p>
            @endforelse
        </div>
        <div class="mt-6 text-center">
            <a href="{{ route('articles') }}"
                class="px-4 py-2 text-black transition-transform duration-300 transform border-2 border-gray-600 rounded-md hover:shadow-lg">Lihat
                Semua</a>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/ScrollTrigger.min.js"></script>
    <script>
        // Perangkat Desa Carousel functionality
        let currentSlide = 0;
        const totalSlides = {{ $perangkatDesas->count() }};
        const itemsPerView = 4; // Number of items visible at once on desktop

        function slideCarousel(direction) {
            const carousel = document.getElementById('perangkatCarousel');
            const maxSlide = Math.max(0, totalSlides - itemsPerView);

            currentSlide += direction;

            if (currentSlide < 0) {
                currentSlide = 0;
            } else if (currentSlide > maxSlide) {
                currentSlide = maxSlide;
            }

            const translateX = -currentSlide * (100 / itemsPerView);
            carousel.style.transform = `translateX(${translateX}%)`;
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Daftarkan plugin ScrollTrigger
            gsap.registerPlugin(ScrollTrigger);

            // Buat animasi untuk elemen dengan kelas .image-container
            gsap.utils.toArray('.image-container').forEach(container => {
                gsap.to(container, {
                    scrollTrigger: {
                        trigger: container,
                        start: 'top 80%', // Mulai animasi saat elemen berada 80% dari bagian atas viewport
                        end: 'top 30%', // Selesai animasi saat elemen berada 30% dari bagian atas viewport
                        toggleActions: 'play none none reverse', // Animasi akan berbalik saat scroll ke atas
                    },
                    opacity: 1,
                    y: 0,
                    duration: 1
                });
            });
        });
    </script>

</x-Layouts.visitor-layout>
