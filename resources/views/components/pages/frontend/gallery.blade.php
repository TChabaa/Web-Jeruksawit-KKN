<x-layouts.visitor-layout>
    <x-slot:title>Galeri</x-slot:title>
    <x-slot:pageTitle>Galeri Foto Desa Jeruksawit - Dokumentasi Wisata dan Kegiatan</x-slot:pageTitle>
    <x-slot:metaDescription>Kumpulan foto dan dokumentasi kegiatan di Desa Jeruksawit, Karanganyar. Lihat galeri wisata,
        acara desa, dan momen bersejarah yang menampilkan keindahan dan kehidupan masyarakat Desa Jeruksawit.</x-slot:metaDescription>
    <x-slot:metaKeywords>galeri desa jeruksawit, foto wisata jeruksawit, dokumentasi desa, galeri karanganyar, foto
        kegiatan desa, wisata jeruksawit, galeri artikel</x-slot:metaKeywords>
    <x-slot:ogTitle>Galeri Desa Jeruksawit - Dokumentasi Wisata dan Kegiatan</x-slot:ogTitle>
    <x-slot:ogDescription>Nikmati koleksi foto dan dokumentasi kegiatan di Desa Jeruksawit. Temukan keindahan wisata dan
        kehidupan masyarakat desa melalui galeri lengkap kami.</x-slot:ogDescription>

    @push('structured-data')
        <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ImageGallery",
        "name": "Galeri Desa Jeruksawit",
        "description": "Kumpulan foto dan dokumentasi kegiatan di Desa Jeruksawit, Karanganyar.",
        "url": "{{ route('galleries') }}",
        "isPartOf": {
            "@type": "WebSite",
            "name": "Desa Jeruksawit",
            "url": "{{ url('/') }}"
        },
        "breadcrumb": {
            "@type": "BreadcrumbList",
            "itemListElement": [
                {
                    "@type": "ListItem",
                    "position": 1,
                    "name": "Beranda",
                    "item": "{{ route('index') }}"
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "Galeri",
                    "item": "{{ route('galleries') }}"
                }
            ]
        }
    }
    </script>
    @endpush

    <div class="pt-30 px-7">
        <div class="">
            <h1 class="mb-10 text-3xl font-extrabold text-center md:text-4xl font-inter">Galeri</h1>
        </div>

        <!-- Article Images Section -->
        <section class="mb-16">
            <h2 class="text-2xl font-bold text-center mb-8 font-inter text-gray-800">Galeri Artikel</h2>
            @if ($articleImages->count() > 0)
                <div class="relative">
                    <div class="overflow-hidden">
                        <div class="flex transition-transform duration-300 ease-in-out" id="articleCarousel">
                            @foreach ($articleImages as $image)
                                <div class="w-full md:w-1/2 lg:w-1/3 xl:w-1/4 flex-shrink-0 px-3">
                                    <div data-aos="zoom-in" data-aos-duration="1000"
                                        class="transition-transform duration-300">
                                        <a href="{{ Storage::url($image->image_url) }}" target="_blank">
                                            <img class="object-cover max-w-full rounded-lg aspect-square"
                                                src="{{ Storage::url($image->image_url) }}"
                                                title="{{ $image->article->title }}"
                                                alt="Gambar artikel {{ $image->article->title }}">
                                        </a>
                                        <p class="text-sm text-center mt-2 text-gray-600 font-inter">
                                            {{ $image->article->title }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if ($articleImages->count() > 4)
                        <button
                            class="absolute left-0 top-1/2 -translate-y-1/2 bg-white rounded-full p-2 shadow-lg hover:bg-gray-50 transition-colors"
                            onclick="slideCarousel('article', -1)">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button
                            class="absolute right-0 top-1/2 -translate-y-1/2 bg-white rounded-full p-2 shadow-lg hover:bg-gray-50 transition-colors"
                            onclick="slideCarousel('article', 1)">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>
                    @endif
                </div>
            @else
                <p class="text-lg text-center text-gray-500 font-inter">Tidak ada gambar artikel</p>
            @endif
        </section>

        <!-- UMKM Images Section -->
        <section class="mb-16">
            <h2 class="text-2xl font-bold text-center mb-8 font-inter text-gray-800">Galeri UMKM</h2>
            @if ($umkmImages->count() > 0)
                <div class="relative">
                    <div class="overflow-hidden">
                        <div class="flex transition-transform duration-300 ease-in-out" id="umkmCarousel">
                            @foreach ($umkmImages as $image)
                                <div class="w-full md:w-1/2 lg:w-1/3 xl:w-1/4 flex-shrink-0 px-3">
                                    <div data-aos="zoom-in" data-aos-duration="1000"
                                        class="transition-transform duration-300">
                                        <a href="{{ Storage::url($image->image_url) }}" target="_blank">
                                            <img class="object-cover max-w-full rounded-lg aspect-square"
                                                src="{{ Storage::url($image->image_url) }}"
                                                title="{{ $image->umkm->nama }}"
                                                alt="Gambar UMKM {{ $image->umkm->nama }}">
                                        </a>
                                        <p class="text-sm text-center mt-2 text-gray-600 font-inter">
                                            {{ $image->umkm->nama }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if ($umkmImages->count() > 4)
                        <button
                            class="absolute left-0 top-1/2 -translate-y-1/2 bg-white rounded-full p-2 shadow-lg hover:bg-gray-50 transition-colors"
                            onclick="slideCarousel('umkm', -1)">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button
                            class="absolute right-0 top-1/2 -translate-y-1/2 bg-white rounded-full p-2 shadow-lg hover:bg-gray-50 transition-colors"
                            onclick="slideCarousel('umkm', 1)">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>
                    @endif
                </div>
            @else
                <p class="text-lg text-center text-gray-500 font-inter">Tidak ada gambar UMKM</p>
            @endif
        </section>

        <!-- Destination Images Section -->
        <section class="mb-16">
            <h2 class="text-2xl font-bold text-center mb-8 font-inter text-gray-800">Galeri Wisata</h2>
            @if ($destinationImages->count() > 0)
                <div class="relative">
                    <div class="overflow-hidden">
                        <div class="flex transition-transform duration-300 ease-in-out" id="destinationCarousel">
                            @foreach ($destinationImages as $gallery)
                                <div class="w-full md:w-1/2 lg:w-1/3 xl:w-1/4 flex-shrink-0 px-3">
                                    <div data-aos="zoom-in" data-aos-duration="1000"
                                        class="transition-transform duration-300">
                                        <a href="{{ Storage::url($gallery->image_url) }}" target="_blank">
                                            <img class="object-cover max-w-full rounded-lg aspect-square"
                                                src="{{ Storage::url($gallery->image_url) }}"
                                                title="{{ $gallery->destination->name }}"
                                                alt="Gambar wisata {{ $gallery->destination->name }}">
                                        </a>
                                        <p class="text-sm text-center mt-2 text-gray-600 font-inter">
                                            {{ $gallery->destination->name }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if ($destinationImages->count() > 4)
                        <button
                            class="absolute left-0 top-1/2 -translate-y-1/2 bg-white rounded-full p-2 shadow-lg hover:bg-gray-50 transition-colors"
                            onclick="slideCarousel('destination', -1)">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button
                            class="absolute right-0 top-1/2 -translate-y-1/2 bg-white rounded-full p-2 shadow-lg hover:bg-gray-50 transition-colors"
                            onclick="slideCarousel('destination', 1)">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    @endif
                </div>
            @else
                <p class="text-lg text-center text-gray-500 font-inter">Tidak ada gambar wisata</p>
            @endif
        </section>
    </div>
</x-layouts.visitor-layout>

<script>
    AOS.init();

    // Carousel functionality for multiple carousels
    let carouselStates = {
        article: {
            currentSlide: 0,
            totalSlides: {{ $articleImages->count() }}
        },
        umkm: {
            currentSlide: 0,
            totalSlides: {{ $umkmImages->count() }}
        },
        destination: {
            currentSlide: 0,
            totalSlides: {{ $destinationImages->count() }}
        }
    };

    const itemsPerView = 4; // Number of items visible at once on desktop

    function slideCarousel(carouselType, direction) {
        const carousel = document.getElementById(carouselType + 'Carousel');
        const state = carouselStates[carouselType];
        const maxSlide = Math.max(0, state.totalSlides - itemsPerView);

        state.currentSlide += direction;

        if (state.currentSlide < 0) {
            state.currentSlide = 0;
        } else if (state.currentSlide > maxSlide) {
            state.currentSlide = maxSlide;
        }

        const translateX = -state.currentSlide * (100 / itemsPerView);
        carousel.style.transform = `translateX(${translateX}%)`;
    }
</script>
