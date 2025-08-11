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

    <footer class="w-full mt-20 text-gray-700 bg-gray-100 body-font">
        <div class="flex flex-col items-center px-5 py-5 md:flex-row ">
            <div class="mx-auto text-center lg:w-1/2 md:mx-0 ">
                <a class="flex items-center justify-center font-medium text-gray-900 title-font ">
                    <img class="w-20" src="{{ asset('assets/img/Karanganyar.png') }}" alt="">
                </a>
                <p class="mt-2 text-sm text-gray-500">Repeh Rapih Kerta Raharja</p>
                <div class="mt-4">
                    <span class="inline-flex justify-center mt-2 sm:ml-auto sm:mt-0 sm:justify-start">
                        <a href="https://web.facebook.com/rakutakside"
                            class="text-gray-500 cursor-pointer hover:text-green-new">
                            <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                class="w-5 h-5" viewBox="0 0 24 24">
                                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                            </svg>
                        </a>
                        <a href="https://www.youtube.com/@sukarame.Info77"
                            class="ml-3 text-gray-500 cursor-pointer hover:text-green-new">
                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M21.7 8.037a4.26 4.26 0 0 0-.789-1.964 2.84 2.84 0 0 0-1.984-.839c-2.767-.2-6.926-.2-6.926-.2s-4.157 0-6.928.2a2.836 2.836 0 0 0-1.983.839 4.225 4.225 0 0 0-.79 1.965 30.146 30.146 0 0 0-.2 3.206v1.5a30.12 30.12 0 0 0 .2 3.206c.094.712.364 1.39.784 1.972.604.536 1.38.837 2.187.848 1.583.151 6.731.2 6.731.2s4.161 0 6.928-.2a2.844 2.844 0 0 0 1.985-.84 4.27 4.27 0 0 0 .787-1.965 30.12 30.12 0 0 0 .2-3.206v-1.516a30.672 30.672 0 0 0-.202-3.206Zm-11.692 6.554v-5.62l5.4 2.819-5.4 2.801Z"
                                    clip-rule="evenodd" />
                            </svg>

                        </a>
                        <a href="https://www.instagram.com/desasukarame2022?igsh=MW55enJkcndiNzNxaw"
                            class="ml-3 text-gray-500 cursor-pointer hover:text-green-new">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5">
                                </rect>
                                <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
                            </svg>
                        </a>

                    </span>
                </div>
            </div>
            <div class="flex flex-wrap flex-grow mt-10 -mb-10 text-center md:pl-20 md:mt-0 md:text-left">

                <div class="w-full px-4 md:w-1/2">

                    <nav class="mb-10 list-none text-md">
                        <li class="mt-3">
                            <a href="{{ route('index') }}"
                                class="text-gray-500 cursor-pointer hover:text-green-new {{ Route::current()->getName() == 'index' ? 'text-green-new' : '' }}">Beranda</a>
                        </li>
                        <li class="mt-3">
                            <a href="{{ route('destinations') }}"
                                class="text-gray-500 cursor-pointer hover:text-green-new {{ in_array(Route::current()->getName(), ['destinations', 'destinations.show']) ? 'text-green-new' : '' }}">Wisata</a>
                        </li>
                        <li class="mt-3">
                            <a href="{{ route('umkm') }}"
                                class="text-gray-500 cursor-pointer hover:text-green-new {{ in_array(Route::current()->getName(), ['umkm', 'umkm.show']) ? 'text-green-new' : '' }}">UMKM</a>
                        </li>
                        <li class="mt-3">
                            <a href="{{ route('galleries') }}"
                                class="text-gray-500 cursor-pointer hover:text-green-new {{ Route::current()->getName() == 'galleries' ? 'text-green-new' : '' }}">Galeri</a>
                        </li>
                    </nav>
                </div>
                <div class="w-full px-4 md:w-1/2">

                    <nav class="mb-10 list-none text-md">

                        <li class="mt-3">
                            <a href="{{ route('articles') }}"
                                class=" cursor-pointer hover:text-green-new {{ in_array(Route::current()->getName(), ['articles', 'articles.show']) ? 'text-green-new' : '' }}">Artikel</a>
                        </li>
                        <li class="mt-3">
                            <a href="{{ route('about-us') }}"
                                class=" cursor-pointer hover:text-green-new {{ Route::current()->getName() == 'about-us' ? 'text-green-new' : '' }}">Tentang
                                Kami</a>
                        </li>
                        <li class="mt-3">
                            <a href="{{ route('layanan-surat') }}"
                                class=" cursor-pointer hover:text-green-new {{ Route::current()->getName() == 'layanan-surat' || str_starts_with(Route::current()->getName(), 'layanan-surat.') ? 'text-green-new' : '' }}">Layanan
                                Surat</a>
                        </li>
                    </nav>
                </div>


            </div>
        </div>
        <div class="bg-#A2AF9B">
            <div class="container px-5 py-4 mx-auto">
                <p class="text-sm font-bold text-center text-white capitalize font-inter">Copyright
                    {{ date('Y') }} Desa
                    Jeruksawit </p>
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
        //     // Toggle kelas 'hidden' pada menu mobile
        //     mobileMenu.classList.toggle('hidden');
        //     // Toggle atribut 'aria-expanded' untuk aksesibilitas
        //     const isOpen = mobileMenu.classList.contains('hidden') ? 'false' : 'true';
        //     toggleButton.setAttribute('aria-expanded', isOpen);

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
