<x-layouts.visitor-layout>
    <x-slot:title>{{ $umkm->name }}</x-slot:title>
    <x-slot:pageTitle>{{ $umkm->name }} - UMKM Desa Jeruksawit Karanganyar</x-slot:pageTitle>
    <x-slot:metaDescription>{{ Str::limit(strip_tags($umkm->description), 155) ?: 'Produk berkualitas dari ' . $umkm->name . ', UMKM unggulan di Desa Jeruksawit, Karanganyar. Dukung ekonomi lokal dengan produk asli dan berkualitas tinggi.' }}</x-slot:metaDescription>
    <x-slot:metaKeywords>{{ strtolower($umkm->name) }}, umkm {{ strtolower($umkm->name) }}, produk jeruksawit, umkm
        karanganyar, usaha lokal jeruksawit, {{ strtolower($umkm->name) }} karanganyar</x-slot:metaKeywords>
    <x-slot:ogTitle>{{ $umkm->name }} - UMKM Desa Jeruksawit</x-slot:ogTitle>
    <x-slot:ogDescription>{{ Str::limit(strip_tags($umkm->description), 155) ?: 'Temukan produk berkualitas dari ' . $umkm->name . ', salah satu UMKM unggulan di Desa Jeruksawit, Karanganyar.' }}</x-slot:ogDescription>
    <x-slot:ogImage>{{ $umkm->gambarUmkm->isNotEmpty() ? Storage::url($umkm->gambarUmkm->first()->image_url) : asset('assets/img/Karanganyar.png') }}</x-slot:ogImage>

    @push('structured-data')
        <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "{{ $umkm->name }}",
        "description": "{{ strip_tags($umkm->description) }}",
        "url": "{{ route('umkm.show', $umkm->slug) }}",
        @if($umkm->gambarUmkm->isNotEmpty())
        "image": [
            @foreach($umkm->gambarUmkm as $gambar)
            "{{ Storage::url($gambar->image_url) }}"{{ !$loop->last ? ',' : '' }}
            @endforeach
        ],
        @endif
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Jeruksawit",
            "addressRegion": "Karanganyar",
            "addressCountry": "ID"
        },
        "telephone": "{{ $umkm->contactUmkm->phone ?? '' }}",
        "email": "{{ $umkm->contactUmkm->email ?? '' }}",
        "priceRange": "$$",
        "openingHoursSpecification": {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
            "opens": "08:00",
            "closes": "17:00"
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
                    "name": "UMKM",
                    "item": "{{ route('umkm') }}"
                },
                {
                    "@type": "ListItem",
                    "position": 3,
                    "name": "{{ $umkm->name }}",
                    "item": "{{ route('umkm.show', $umkm->slug) }}"
                }
            ]
        }
    }
    </script>
    @endpush

    <div class="grid gap-5 px-4 mx-auto max-w-7xl md:grid-cols-2 md:px-6 pt-35 font-inter">
        <div class="">
            <div class="grid gap-4">
                <div>
                    <img class="object-cover object-center w-full h-auto max-w-full rounded-lg aspect-[4/3]"
                        id="expandedImg" src="{{ Storage::url($umkm->gambarUmkm[0]->image_url) }}" alt="">
                </div>
                <div class="overflow-x-auto">
                    <div class="inline-flex gap-3 h-15">
                        @foreach ($umkm->gambarUmkm as $gambar)
                            <img class="h-auto max-w-full cursor-pointer object-cover object-center rounded-lg aspect-[4/3] imgClick"
                                src="{{ Storage::url($gambar->image_url) }}" alt="">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="space-y-5">
                <div class="space-y-2">
                    <h1 class="text-2xl font-bold md:text-3xl">{{ $umkm->nama }}</h1>
                    <span class="flex items-center text-sm text-black gap-1">
                        <svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2"
                                d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        {{ number_format($umkm->views) }}x Telah Dilihat
                    </span>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi :</label>
                        <div class="flex gap-2">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                    <path
                                        d="M12 2C7.589 2 4 5.589 4 9.995 3.971 16.44 11.696 21.784 12 22c0 0 8.029-5.56 8-12 0-4.411-3.589-8-8-8zm0 12c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z">
                                    </path>
                                </svg>
                            </div>
                            <a href="{{ $umkm->gmaps_url }}" target="_blank">
                                <address class="text-sm text-deep-koamaru-500 capitalize lg:text-base">
                                    {{ $umkm->alamat }}
                                </address>
                            </a>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi :</label>
                    <p class="text-gray-500 md:text-lg">{{ $umkm->deskripsi }}</p>
                </div>
            </div>
            <div class="">
                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                        data-tabs-toggle="#default-tab-content" role="tablist">
                        <li class="me-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab"
                                data-tabs-target="#profile" type="button" role="tab" aria-controls="profile"
                                aria-selected="false">Jadwal Operasional</button>
                        </li>
                        <li role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                id="contacts-tab" data-tabs-target="#contacts" type="button" role="tab"
                                aria-controls="contacts" aria-selected="false">Kontak UMKM</button>
                        </li>
                    </ul>
                </div>
                <div id="default-tab-content">
                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel"
                        aria-labelledby="profile-tab">
                        <p class="capitalize">
                            {{ $openingHours[0] . '-' . $openingHours[1] . ', ' . date('H:i', strtotime($openingHours[2])) . '-' . date('H:i', strtotime($openingHours[3])) . ' WIB' }}
                        </p>
                    </div>
                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="contacts" role="tabpanel"
                        aria-labelledby="contacts-tab">
                        @if ($umkm->contactUmkm && $umkm->contactUmkm->nomor)
                            <div class="flex gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z">
                                    </path>
                                </svg>
                                {{ $umkm->contactUmkm->nomor }}
                            </div>
                        @endif

                        @if ($umkm->contactUmkm && $umkm->contactUmkm->email)
                            <div class="flex gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z">
                                    </path>
                                </svg>
                                {{ $umkm->contactUmkm->email }}
                            </div>
                        @endif

                        @if ($umkm->contactUmkm && $umkm->contactUmkm->sosial_media)
                            <div class="flex gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z">
                                    </path>
                                </svg>
                                <a href="{{ $umkm->contactUmkm->sosial_media }}" class="underline">Klik
                                    untuk melihat sosial media</a>
                            </div>
                        @endif

                        @if (
                            !$umkm->contactUmkm ||
                                (!$umkm->contactUmkm->nomor && !$umkm->contactUmkm->email && !$umkm->contactUmkm->sosial_media))
                            <p>Belum ada kontak yang tersedia</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3 mt-6 text-green-new">
            <svg class="w-6 h-6 text-green-new dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 12h14M5 12l4-4m-4 4 4 4" />
            </svg>
            <a href="{{ url()->previous() }}">Kembali </a>
        </div>
    </div>
</x-layouts.visitor-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const expandedImg = document.getElementById('expandedImg');
        const imgClick = document.querySelectorAll('.imgClick');

        imgClick.forEach(function(element) {
            element.addEventListener('click', function() {
                expandedImg.src = this.src;
            });
        });
    })

    // Text Elipsis via javascript
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

    shortenText(".elipsis", 450, true);
</script>
