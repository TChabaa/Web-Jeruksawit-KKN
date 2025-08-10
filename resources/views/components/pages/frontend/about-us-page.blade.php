<x-Layouts.visitor-layout>
    <x-slot:title>Tentang Kami</x-slot:title>
    <x-slot:pageTitle>Tentang Kami - Profil Desa Jeruksawit Karanganyar</x-slot:pageTitle>
    <x-slot:metaDescription>Pelajari lebih lanjut tentang Desa Jeruksawit, Karanganyar. Kenali sejarah, visi misi, perangkat
        desa, dan komitmen kami dalam membangun desa wisata yang berkelanjutan dan sejahtera bagi masyarakat.</x-slot:metaDescription>
    <x-slot:metaKeywords>tentang desa jeruksawit, profil desa jeruksawit, sejarah jeruksawit, perangkat desa jeruksawit,
        visi misi jeruksawit, pemerintah desa karanganyar, profil karanganyar</x-slot:metaKeywords>
    <x-slot:ogTitle>Tentang Kami - Profil Desa Jeruksawit Karanganyar</x-slot:ogTitle>
    <x-slot:ogDescription>Mengenal lebih dekat Desa Jeruksawit, sejarah, perangkat desa, dan komitmen dalam membangun
        desa wisata yang berkelanjutan di Karanganyar, Jawa Tengah.</x-slot:ogDescription>

    @push('structured-data')
        <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "AboutPage",
        "name": "Tentang Desa Jeruksawit",
        "description": "Halaman tentang Desa Jeruksawit yang berisi profil, sejarah, visi misi, dan informasi perangkat desa.",
        "url": "{{ route('about-us') }}",
        "mainEntity": {
            "@type": "GovernmentOrganization",
            "name": "Pemerintah Desa Jeruksawit",
            "description": "Pemerintahan desa yang berkomitmen membangun Desa Jeruksawit sebagai desa wisata berkelanjutan.",
            "address": {
                "@type": "PostalAddress",
                "addressLocality": "Jeruksawit",
                "@type": "PostalAddress",
                "addressRegion": "Karanganyar",
                "addressCountry": "ID"
            }
        },
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
                    "name": "Tentang Kami",
                    "item": "{{ route('about-us') }}"
                }
            ]
        }
    }
    </script>
    @endpush
    <header>
        <x-partials.frontend.header />
    </header>

    <section class="mx-auto  max-w-7xl">

        <x-partials.frontend.description />
    </section>

    <!-- Perangkat Desa Section -->
    <section class="bg-white py-16 font-inter">
        <div class="max-w-7xl mx-auto px-4">
            <div class="mb-12 text-center">
                <h2 class="text-4xl font-extrabold text-gray-900 mb-4">Perangkat Desa Jeruksawit</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Tim perangkat desa yang berkomitmen tinggi untuk melayani dan memajukan Desa Jeruksawit dengan
                    dedikasi penuh
                </p>
            </div>

            @if ($perangkatDesas->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($perangkatDesas as $perangkatDesa)
                        <x-partials.frontend.card-perangkat-desa :$perangkatDesa />
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="max-w-md mx-auto">
                        <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Data</h3>
                        <p class="text-gray-500">Data perangkat desa belum tersedia saat ini</p>
                    </div>
                </div>
            @endif
        </div>
    </section>



</x-Layouts.visitor-layout>
