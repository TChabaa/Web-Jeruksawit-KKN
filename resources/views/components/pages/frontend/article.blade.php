<x-layouts.visitor-layout>
    <x-slot:title>Artikel</x-slot:title>
    <x-slot:pageTitle>Artikel Desa Jeruksawit - Informasi dan Berita Terkini</x-slot:pageTitle>
    <x-slot:metaDescription>Baca artikel terbaru tentang Desa Jeruksawit, Karanganyar. Dapatkan informasi terkini tentang
        kegiatan desa, wisata, UMKM, dan berbagai program pembangunan desa yang sedang berjalan.</x-slot:metaDescription>
    <x-slot:metaKeywords>artikel jeruksawit, berita desa jeruksawit, informasi jeruksawit, kabar terbaru karanganyar,
        artikel wisata jeruksawit, berita umkm jeruksawit, update desa jeruksawit</x-slot:metaKeywords>
    <x-slot:ogTitle>Artikel Desa Jeruksawit - Informasi dan Berita Terkini</x-slot:ogTitle>
    <x-slot:ogDescription>Ikuti perkembangan terbaru Desa Jeruksawit melalui artikel dan berita terupdate. Temukan
        informasi menarik tentang wisata, UMKM, dan kegiatan masyarakat desa.</x-slot:ogDescription>

    @push('structured-data')
        <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Blog",
        "name": "Artikel Desa Jeruksawit",
        "description": "Kumpulan artikel dan berita terbaru tentang Desa Jeruksawit, Karanganyar yang membahas wisata, UMKM, dan kegiatan masyarakat desa.",
        "url": "{{ route('articles') }}",
        "publisher": {
            "@type": "Organization",
            "name": "Pemerintah Desa Jeruksawit",
            "logo": {
                "@type": "ImageObject",
                "url": "{{ asset('assets/img/Karanganyar.png') }}"
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
                    "name": "Artikel",
                    "item": "{{ route('articles') }}"
                }
            ]
        }
    }
    </script>
    @endpush

    <div class="pt-30 font-inter ">
        <div class="text-4xl font-extrabold text-center">
            <h1 class="font-inter">Artikel</h1>
        </div>

        <div class="">
            <form class="max-w-md px-10 mx-auto my-10" action="{{ route('articles') }}" method="GET">
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
                        placeholder="Cari Artikel..." required />
                    <button type="submit"
                        class="text-white absolute end-2.5 bottom-2.5 bg-[#A2AF9B] hover:bg-opacity-90 focus:ring-4 focus:outline-none focus:ring-green-new font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cari</button>
                </div>
            </form>
        </div>
        <div
            class="grid gap-6 px-3 mx-auto mt-10 xl:grid-cols-3 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 max-w-7xl justify-items-center">
            @forelse ($articles as $article)
                <div class="w-full max-w-sm">
                    <x-partials.frontend.card-article :article="$article" />
                </div>
            @empty
                <div class="col-span-full">
                    <p class="text-xl font-semibold text-center text-gray-600">Tidak ada Artikel</p>
                </div>
            @endforelse
        </div>
    </div>

    @if ($articles->lastPage() > 1)
        <div class="px-5 mx-auto mt-10 max-w-7xl">
            {{ $articles->links() }}
        </div>
    @endif

</x-layouts.visitor-layout>


<script>
    function shortenText(elementSelector, maxLength, elipsis) {
        let elements = document.querySelectorAll(elementSelector);

        elements.forEach(function(element) {
            let textContent = element.textContent.trim();

            if (textContent.length > maxLength) {
                if (elipsis) {
                    let shortenedContent =
                        textContent.substring(0, maxLength) + " ...";
                    element.textContent = shortenedContent;
                } else {
                    let shortenedContent = textContent.substring(0, maxLength);
                    element.textContent = shortenedContent;
                }
            }
        });
    }

    shortenText(".paragraph", 500, true);
    shortenText(".title", 50, true);
</script>
