<x-Layouts.visitor-layout>

    <x-slot:title>Layanan Surat Menyurat</x-slot:title>
    <x-slot:pageTitle>Layanan Surat Menyurat Online Desa Jeruksawit - Mudah dan Cepat</x-slot:pageTitle>
    <x-slot:metaDescription>Layanan surat menyurat online Desa Jeruksawit untuk berbagai keperluan administrasi. Ajukan
        SKCK, SKTM, Surat Belum Menikah, Izin Keramaian, dan surat lainnya secara online dengan mudah dan cepat.</x-slot:metaDescription>
    <x-slot:metaKeywords>layanan surat jeruksawit, surat online jeruksawit, skck jeruksawit, sktm jeruksawit, surat belum
        menikah, izin keramaian, administrasi desa jeruksawit, layanan online karanganyar</x-slot:metaKeywords>
    <x-slot:ogTitle>Layanan Surat Menyurat Online Desa Jeruksawit</x-slot:ogTitle>
    <x-slot:ogDescription>Nikmati kemudahan layanan surat menyurat online Desa Jeruksawit. Ajukan berbagai jenis surat
        administrasi dengan proses yang mudah, cepat, dan efisien.</x-slot:ogDescription>

    @push('structured-data')
        <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "GovernmentService",
        "name": "Layanan Surat Menyurat Desa Jeruksawit",
        "description": "Layanan surat menyurat online untuk berbagai keperluan administrasi di Desa Jeruksawit, Karanganyar.",
        "url": "{{ route('layanan-surat') }}",
        "provider": {
            "@type": "GovernmentOrganization",
            "name": "Pemerintah Desa Jeruksawit"
        },
        "areaServed": {
            "@type": "Place",
            "name": "Desa Jeruksawit, Karanganyar"
        },
        "serviceType": [
            "SKCK",
            "SKTM",
            "Surat Belum Menikah",
            "Izin Keramaian",
            "Keterangan Usaha",
            "Keterangan Kematian",
            "Keterangan Kelahiran",
            "Orang yang Sama",
            "Pindah Keluar",
            "Domisili Instansi",
            "Domisili Kelompok",
            "Domisili Orang"
        ],
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
                    "name": "Layanan Surat",
                    "item": "{{ route('layanan-surat') }}"
                }
            ]
        }
    }
    </script>
    @endpush
    <section class="px-6 mx-auto py-30 max-w-7xl font-inter">
        <div class="mb-10 text-center">
            <h1 class="mb-4 text-3xl font-bold text-gray-800 md:text-4xl">Layanan Surat Menyurat</h1>
            <p class="max-w-3xl mx-auto text-gray-600">
                Silakan pilih jenis surat yang Anda butuhkan di bawah ini. Setiap jenis surat akan meminta
                beberapa
                informasi dasar dan dokumen
                pendukung yang diperlukan. Setelah mengisi formulir, surat akan langsung ke email anda sesuai
                format
                untuk kemudian bisa dikirimkan ke
                Pemerintah Desa Jeruksawit untuk diproses. Proses ini akan membantu Anda mendapatkan surat yang
                diperlukan dengan cepat dan mudah.
            </p>
        </div>

        @if (session('success'))
            <div class="p-4 mb-8 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                <span class="font-medium">Berhasil!</span> {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <!-- SKCK -->
            <x-partials.surat-card title="SKCK"
                description="Surat Keterangan Catatan Kepolisian diperluakan untuk keperluan melamar pekerjaan, mengurus visa, atau keperluan lainnya yang memerlukan bukti catatan kepolisian."
                url="{{ route('layanan-surat.form', 'skck') }}">
                <x-slot name="icon">
                    <svg class="w-8 h-8 text-green-new" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                </x-slot>
            </x-partials.surat-card>

            <!-- Izin Keramaian -->
            <x-partials.surat-card title="Izin Keramaian"
                description="Surat izin untuk mengadakan acara/keramaian seperti hajatan, konser, atau acara lainnya yang melibatkan banyak orang."
                url="{{ route('layanan-surat.form', 'izin-keramaian') }}">
                <x-slot name="icon">
                    <svg class="w-8 h-8 text-green-new" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </x-slot>
            </x-partials.surat-card>

            <!-- Keterangan Usaha -->
            <x-partials.surat-card title="Keterangan Usaha"
                description="Surat keterangan untuk keperluan usaha yang biasanya digunakan untuk keperluan pengajuan kredit atau legalitas usaha."
                url="{{ route('layanan-surat.form', 'keterangan-usaha') }}">
                <x-slot name="icon">
                    <svg class="w-8 h-8 text-green-new" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                </x-slot>
            </x-partials.surat-card>
            <!-- SKTM -->
            <x-partials.surat-card title="SKTM"
                description="Surat Keterangan Tidak Mampu diperluakan untuk berbagai keperluan administratif, seperti bantuan sosial, pembebasan biaya sekolah, atau keperluan lainnya."
                url="{{ route('layanan-surat.form', 'sktm') }}">
                <x-slot name="icon">
                    <svg class="w-8 h-8 text-green-new" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </x-slot>
            </x-partials.surat-card>

            <!-- Belum Menikah -->
            <x-partials.surat-card title="Belum Menikah"
                description="Surat keterangan belum menikah yang biasanya digunakan untuk keperluan administrasi, pendaftaran pernikahan, atau keperluan lainnya."
                url="{{ route('layanan-surat.form', 'belum-menikah') }}">
                <x-slot name="icon">
                    <svg class="w-8 h-8 text-green-new" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                        </path>
                    </svg>
                </x-slot>
            </x-partials.surat-card>
            <!-- Keterangan Kematian -->
            <x-partials.surat-card title="Keterangan Kematian"
                description="Surat keterangan kematian yang digunakan untuk keperluan administrasi, klaim asuransi, atau keperluan lainnya terkait dengan kematian seseorang."
                url="{{ route('layanan-surat.form', 'keterangan-kematian') }}">
                <x-slot name="icon">
                    <svg class="w-8 h-8 text-green-new" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </x-slot>
            </x-partials.surat-card>

            <!-- Keterangan Kelahiran -->
            <x-partials.surat-card title="Keterangan Kelahiran"
                description="Surat keterangan kelahiran yang digunakan untuk keperluan administrasi, pembuatan akta kelahiran, atau keperluan lainnya terkait dengan kelahiran."
                url="{{ route('layanan-surat.form', 'keterangan-kelahiran') }}">
                <x-slot name="icon">
                    <svg class="w-8 h-8 text-green-new" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m3 5.197v0a2.25 2.25 0 00-3-2.122 2.25 2.25 0 00-3 2.122v0">
                        </path>
                    </svg>
                </x-slot>
            </x-partials.surat-card>
            <!-- Orang yang Sama -->
            <x-partials.surat-card title="Orang yang Sama"
                description="Surat keterangan orang yang sama yang digunakan untuk menyatakan bahwa dua identitas yang berbeda merujuk pada orang yang sama."
                url="{{ route('layanan-surat.form', 'orang-yang-sama') }}">
                <x-slot name="icon">
                    <svg class="w-8 h-8 text-green-new" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </x-slot>
            </x-partials.surat-card>
            <!-- Pindah Keluar -->
            <x-partials.surat-card title="Pindah Keluar"
                description="Surat keterangan pindah keluar yang digunakan untuk keperluan administrasi kependudukan ketika seseorang pindah dari satu daerah ke daerah lain."
                url="{{ route('layanan-surat.form', 'pindah-keluar') }}">
                <x-slot name="icon">
                    <svg class="w-8 h-8 text-green-new" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v0"></path>
                    </svg>
                </x-slot>
            </x-partials.surat-card>
            <!-- Domisili Instansi -->
            <x-partials.surat-card title="Domisili Instansi"
                description="Surat keterangan domisili instansi yang digunakan untuk menyatakan alamat resmi dari suatu instansi, lembaga, atau organisasi."
                url="{{ route('layanan-surat.form', 'domisili-instansi') }}">
                <x-slot name="icon">
                    <svg class="w-8 h-8 text-green-new" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                </x-slot>
            </x-partials.surat-card>
            <!-- Domisili Kelompok -->
            <x-partials.surat-card title="Domisili Kelompok"
                description="Surat keterangan domisili kelompok yang digunakan untuk menyatakan alamat resmi dari suatu kelompok, komunitas, atau perkumpulan."
                url="{{ route('layanan-surat.form', 'domisili-kelompok') }}">
                <x-slot name="icon">
                    <svg class="w-8 h-8 text-green-new" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </x-slot>
            </x-partials.surat-card>
            <!-- Domisili Orang -->
            <x-partials.surat-card title="Domisili Orang"
                description="Surat keterangan domisili orang yang digunakan untuk menyatakan tempat tinggal/domisili seseorang untuk keperluan administrasi."
                url="{{ route('layanan-surat.form', 'domisili-orang') }}">
                <x-slot name="icon">
                    <svg class="w-8 h-8 text-green-new" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </x-slot>
            </x-partials.surat-card>
        </div>
    </section>
</x-Layouts.visitor-layout>
