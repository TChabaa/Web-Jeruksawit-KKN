<!DOCTYPE html>
<html lang="id" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- Basic SEO Meta Tags --}}
    <title>{{ $title ?? 'Beranda' }} Desa Jeruksawit - {{ $pageTitle ?? 'Portal Resmi Desa Jeruksawit Karanganyar' }}
    </title>
    <meta name="description"
        content="{{ $metaDescription ?? 'Portal resmi Desa Jeruksawit, Karanganyar. Nikmati wisata, UMKM lokal, layanan surat menyurat online, dan informasi terkini tentang desa wisata terbaik di Karanganyar.' }}">
    <meta name="keywords"
        content="{{ $metaKeywords ?? 'desa jeruksawit, karanganyar, wisata desa, umkm, layanan surat, pemerintah desa, wisata karanganyar, desa wisata jawa tengah' }}">
    <meta name="author" content="Pemerintah Desa Jeruksawit">
    <meta name="robots" content="{{ $metaRobots ?? 'index, follow' }}">
    <link rel="canonical" href="{{ $canonicalUrl ?? url()->current() }}">

    {{-- Open Graph Meta Tags --}}
    <meta property="og:title" content="{{ $ogTitle ?? ($title ?? 'Beranda') . ' Desa Jeruksawit' }}">
    <meta property="og:description"
        content="{{ $ogDescription ?? ($metaDescription ?? 'Portal resmi Desa Jeruksawit, Karanganyar. Nikmati wisata, UMKM lokal, layanan surat menyurat online, dan informasi terkini tentang desa wisata terbaik di Karanganyar.') }}">
    <meta property="og:image" content="{{ $ogImage ?? asset('assets/img/Karanganyar.png') }}">
    <meta property="og:url" content="{{ $ogUrl ?? url()->current() }}">
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <meta property="og:site_name" content="Desa Jeruksawit">
    <meta property="og:locale" content="id_ID">

    {{-- Twitter Card Meta Tags --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $twitterTitle ?? ($title ?? 'Beranda') . ' Desa Jeruksawit' }}">
    <meta name="twitter:description"
        content="{{ $twitterDescription ?? ($metaDescription ?? 'Portal resmi Desa Jeruksawit, Karanganyar. Nikmati wisata, UMKM lokal, layanan surat menyurat online, dan informasi terkini tentang desa wisata terbaik di Karanganyar.') }}">
    <meta name="twitter:image" content="{{ $twitterImage ?? asset('assets/img/Karanganyar.png') }}">

    {{-- Additional SEO Meta Tags --}}
    <meta name="theme-color" content="#A2AF9B">
    <meta name="msapplication-TileColor" content="#A2AF9B">
    <meta name="geo.region" content="ID-JI">
    <meta name="geo.placename" content="Jeruksawit, Karanganyar">
    <meta name="ICBM" content="-7.5167, 110.8167">
    <meta name="language" content="Indonesian">
    <meta name="distribution" content="global">
    <meta name="rating" content="general">
    <meta name="coverage" content="Worldwide">
    <meta name="target" content="all">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    {{-- Favicon and Icons --}}
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/Karanganyar.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/Karanganyar.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/Karanganyar.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/Karanganyar.png') }}" type="image/x-icon">

    {{-- Structured Data for Organization --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "GovernmentOrganization",
        "name": "Pemerintah Desa Jeruksawit",
        "alternateName": "Desa Jeruksawit",
        "description": "Portal resmi Pemerintah Desa Jeruksawit, Karanganyar yang menyediakan informasi wisata, UMKM, dan layanan administrasi kepada masyarakat.",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('assets/img/Karanganyar.png') }}",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Jeruksawit",
            "addressRegion": "Karanganyar",
            "addressCountry": "ID"
        },
        "areaServed": {
            "@type": "Place",
            "name": "Desa Jeruksawit, Karanganyar"
        }
    }
    </script>

    {{-- External CSS with Performance Optimization --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @stack('style')
    @stack('structured-data')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header class="fixed z-50 w-full font-inter" id="myElement">
        <nav class="bg-white border-gray-200 py-2.5">
            <div class="flex flex-wrap items-center justify-between max-w-screen-xl px-4 mx-auto lg:px-8 ">
                <div href="#" class="flex items-center">
                    <img src="{{ asset('assets/img/Karanganyar.png') }}" class="h-12 mr-3 md:h-20"
                        alt="Desa Jeruksawit" />
                </div>

                <button data-collapse-toggle="mobile-menu-2" type="button"
                    class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 "
                    aria-controls="mobile-menu-2" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>

                <div class="items-center justify-between hidden w-full lg:flex lg:w-auto lg:order-1 "
                    id="mobile-menu-2">
                    <ul class="flex flex-col mt-4 font-medium lg:items-center lg:flex-row lg:space-x-8 lg:mt-0">
                        <li>
                            <a href="{{ route('index') }}"
                                class="block py-2 pl-3 pr-4 text-gray-700 lg:hover:text-green-new lg:p-0 {{ Route::current()->getName() == 'index' ? 'text-green-new' : '' }}">Beranda</a>
                        </li>
                        <li>
                            <a href="{{ route('destinations') }}"
                                class="block py-2 pl-3 pr-4 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-green-new lg:p-0 {{ in_array(Route::current()->getName(), ['destinations', 'destinations.show']) ? 'text-green-new' : '' }}">Wisata</a>
                        </li>
                        <li>
                            <a href="{{ route('umkm') }}"
                                class="block py-2 pl-3 pr-4 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-green-new lg:p-0 {{ in_array(Route::current()->getName(), ['umkm', 'umkm.show']) ? 'text-green-new' : '' }}">UMKM</a>
                        </li>

                        <li>
                            <a href="{{ route('articles') }}"
                                class="block py-2 pl-3 pr-4 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-green-new lg:p-0 {{ in_array(Route::current()->getName(), ['articles', 'articles.show']) ? 'text-green-new' : '' }} ">Artikel</a>
                        </li>
                        <li>
                            <a href="{{ route('galleries') }}"
                                class="block py-2 pl-3 pr-4 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-green-new lg:p-0 {{ Route::current()->getName() == 'galleries' ? 'text-green-new' : '' }}">Galeri</a>
                        </li>



                        <li>
                            <a href="{{ route('about-us') }}"
                                class="block py-2 pl-3 pr-4 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-green-new lg:p-0 {{ Route::current()->getName() == 'about-us' ? 'text-green-new' : '' }}">Tentang
                                Kami</a>
                        </li>
                        <li>
                            <a href="{{ route('layanan-surat') }}"
                                class="block py-2 pl-3 pr-4 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-green-new lg:p-0 {{ Route::current()->getName() == 'layanan-surat' || str_starts_with(Route::current()->getName(), 'layanan-surat.') ? 'text-green-new' : '' }}">Layanan
                                Surat</a>
                        </li>

                        @auth
                            <li>
                                <a href="{{ route(auth()->user()->role . '.dashboard') }}"
                                    class="block py-2 pl-3 pr-4 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-green-new lg:p-0">Dashboard</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}" title="Login"
                                    class="block py-2 pl-3 pr-4 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-green-new lg:p-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                    </svg>
                                </a>
                            </li>
                        @endauth
                    </ul>

                </div>

            </div>
        </nav>
    </header>

    <section class="min-h-screen">
        {{ $slot }}
    </section>

    <footer class="bg-gray-100 border-t border-gray-200">
        <div
            class="max-w-screen-xl mx-auto px-5 py-12 grid grid-cols-1 lg:grid-cols-5 gap-y-10 lg:gap-x-6 font-semibold">

            <!-- 1. Logo -->
            <div class="flex justify-center lg:justify-start lg:mr-8">
                <img class="w-32 lg:w-40" src="{{ asset('assets/img/logo.png') }}" alt="Logo Desa Jeruksawit">
            </div>

            <!-- 2. Kontak Kami -->
            <div class="text-center lg:text-left lg:mr-12 mb-8 lg:mb-0">
                <h3 class="text-lg font-bold mb-2">Kontak Kami</h3>
                <p class="flex items-center justify-center lg:justify-left">
                    <a href="https://wa.me/6282134352060"
                        class="ml-2 text-blue-600 hover:underline">+62821-3435-2060</a>
                </p>
                <p class="flex items-center justify-center lg:justify-start mb-2 break-all">
                    <a href="mailto:kantordesajeruksawit@gmail.com" class="ml-2 text-blue-600 hover:underline">
                        kantordesajeruksawit@gmail.com
                    </a>
                </p>
            </div>

            <!-- 3. Jam Kerja -->
            <div class="text-center lg:text-left lg:mr-1 lg:ml-6"> <!-- lg:ml-6 adds space between table 2 & 3 -->
                <h3 class="text-lg font-bold mb-2">Jam Kerja</h3>
                <p>Senin - Jumat: 08.00 - 16.00</p>
                <p>Sabtu: 08.00 - 12.00</p>
                <p>Minggu & Hari Libur: Tutup</p>
            </div>

            <!-- 4. Navigasi Utama -->
            <div class="text-center lg:text-left lg:ml-15">
                <ul>
                    <li><a href="/" class="hover:underline">Beranda</a></li>
                    <li><a href="/wisata" class="hover:underline">Wisata</a></li>
                    <li><a href="/umkm" class="hover:underline">UMKM</a></li>
                    <li><a href="/galeri" class="hover:underline">Galeri</a></li>
                </ul>
            </div>

            <!-- 5. Navigasi Lain -->
            <div class="text-center lg:text-left">
                <ul>
                    <li><a href="/artikel" class="hover:underline">Artikel</a></li>
                    <li><a href="/tentang" class="hover:underline">Tentang Kami</a></li>
                    <li><a href="/layanan-surat" class="hover:underline">Layanan Surat Menyurat</a></li>
                </ul>
            </div>

        </div>
    </footer>

    <script>
        const myElement = document.getElementById('myElement');
        const scrollTrigger = 20; // Tinggi scroll yang memicu shadow (sesuaikan nilai ini)

        window.addEventListener('scroll', function() {
            if (window.scrollY > scrollTrigger) {
                myElement.classList.add('shadow-lg'); // Tambahkan class shadow
            } else {
                myElement.classList.remove('shadow-lg'); // Hapus class shadow
            }
        });

        // Ambil tombol toggle dan menu mobile
        // const toggleButton = document.querySelector('[data-collapse-toggle="mobile-menu-2"]');
        // const mobileMenu = document.getElementById('mobile-menu-2');

        // // Tambahkan event listener untuk klik pada tombol toggle
        // toggleButton.addEventListener('click', function() {
        // // Toggle kelas 'hidden' pada menu mobile
        // mobileMenu.classList.toggle('hidden');
        // // Toggle atribut 'aria-expanded' untuk aksesibilitas
        // const isOpen = mobileMenu.classList.contains('hidden') ? 'false' : 'true';
        // toggleButton.setAttribute('aria-expanded', isOpen);

        // });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollToPlugin.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/TextPlugin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

</body>

</html>
