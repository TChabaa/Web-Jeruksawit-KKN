<x-layouts.visitor-layout>

    <x-slot:title>Tempat Wisata</x-slot:title>
    <x-slot:pageTitle>Tempat Wisata Desa Jeruksawit - Destinasi Wisata Terbaik Karanganyar</x-slot:pageTitle>
    <x-slot:metaDescription>Jelajahi tempat wisata menarik di Desa Jeruksawit, Karanganyar. Nikmati keindahan alam, wisata
        budaya, dan berbagai destinasi menarik di desa wisata terbaik Jawa Tengah dengan pemandangan yang
        memukau.</x-slot:metaDescription>
    <x-slot:metaKeywords>wisata jeruksawit, tempat wisata karanganyar, destinasi jeruksawit, wisata desa jeruksawit,
        wisata alam karanganyar, objek wisata jeruksawit, desa wisata jawa tengah</x-slot:metaKeywords>
    <x-slot:ogTitle>Tempat Wisata Desa Jeruksawit - Destinasi Menarik Karanganyar</x-slot:ogTitle>
    <x-slot:ogDescription>Temukan pesona wisata Desa Jeruksawit dengan berbagai destinasi menarik. Nikmati keindahan
        alam, budaya lokal, dan pengalaman wisata tak terlupakan di Karanganyar.</x-slot:ogDescription>

    @push('structured-data')
        <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "TouristDestination",
        "name": "Tempat Wisata Desa Jeruksawit",
        "description": "Kumpulan destinasi wisata menarik di Desa Jeruksawit, Karanganyar yang menawarkan keindahan alam dan budaya lokal.",
        "url": "{{ route('destinations') }}",
        "isPartOf": {
            "@type": "WebSite",
            "name": "Desa Jeruksawit",
            "url": "{{ url('/') }}"
        },
        "touristType": ["EcoTourist", "CulturalTourist", "NatureTourist"],
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Jeruksawit",
            "addressRegion": "Karanganyar",
            "addressCountry": "ID"
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
                    "name": "Wisata",
                    "item": "{{ route('destinations') }}"
                }
            ]
        }
    }
    </script>
    @endpush

    <section class="px-6 mx-auto py-30 max-w-7xl font-inter">
        <div class="text-4xl font-extrabold text-center">
            <h1 class="font-inter">Tempat Wisata</h1>
        </div>
        <div class="">

            <form class="max-w-md mx-auto my-10" action="{{ route('destinations') }}" method="GET">
                <label for="default-search"
                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Cari</label>
                <div class="relative">
                    <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" name="keyword" id="default-search"
                        class="block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 bg-gray-50 focus:ring-green-new focus:border-green-new dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Cari Tempat Wisata..." required />
                    <button type="submit"
                        class="text-white absolute end-2.5 bottom-2.5 bg-[#A2AF9B] hover:bg-opacity-90 focus:ring-4 focus:outline-none focus:ring-green-new font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cari</button>
                </div>
            </form>


        </div>
        <div
            class="grid items-center gap-4 xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 justify-items-center">
            @forelse ($destinations as $destination)
                <x-partials.frontend.card-destination :$destination />
            @empty
                <p class="font-semibold text-center text-gray-500">Tidak ada tempat wisata</p>
            @endforelse
        </div>

        @if ($destinations->lastPage() > 1)
            <div class="mt-10">
                {{ $destinations->links() }}
            </div>
        @endif
    </section>
    <script>
        // use a script tag or an external JS file
        document.addEventListener("DOMContentLoaded", (event) => {
            gsap.registerPlugin(ScrollTrigger, ScrollToPlugin, TextPlugin)
            gsap.defaults({
                ease: "power3"
            });
            gsap.set(".card", {
                y: 100
            });

            ScrollTrigger.batch(".card", {

                onEnter: batch => gsap.to(batch, {
                    opacity: 1,
                    y: 0,
                    stagger: {
                        each: 0.15,

                    },
                    overwrite: true
                }),
                onLeave: batch => gsap.set(batch, {
                    opacity: 0,
                    y: -100,
                    overwrite: true
                }),
                onEnterBack: batch => gsap.to(batch, {
                    opacity: 1,
                    y: 0,
                    stagger: 0.15,
                    overwrite: true
                }),
                onLeaveBack: batch => gsap.set(batch, {
                    opacity: 0,
                    y: 100,
                    overwrite: true
                })
            });

            ScrollTrigger.addEventListener("refreshInit", () => gsap.set(".card", {
                y: 0
            }));
        });
    </script>
    </x-layouts.navbar>
