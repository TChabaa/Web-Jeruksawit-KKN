<x-layouts.dashboard>
    <x-slot:title>Pilih Jenis Surat</x-slot:title>

    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Pilih Jenis Surat</h1>
                    <p class="mt-2 text-sm text-gray-700">Pilih jenis surat yang akan dibuat</p>
                </div>
                <a href="{{ route(auth()->user()->role . '.layanan-surat') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Letter Type Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- SKCK -->
            <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-500 rounded-md flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <h3 class="text-lg font-medium text-gray-900">SKCK</h3>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Surat Keterangan Catatan Kepolisian untuk keperluan administrasi yang memerlukan bukti tidak
                        memiliki catatan kriminal.
                    </p>
                    <div class="mt-4">
                        <a href="{{ route(auth()->user()->role . '.layanan-surat.form', 'skck') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Buat Surat
                        </a>
                    </div>
                </div>
            </div>

            <!-- Izin Keramaian -->
            <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-purple-500 rounded-md flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <h3 class="text-lg font-medium text-gray-900">Izin Keramaian</h3>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Surat izin untuk mengadakan acara/keramaian seperti hajatan, konser, atau acara lainnya yang
                        melibatkan banyak orang.
                    </p>
                    <div class="mt-4">
                        <a href="{{ route(auth()->user()->role . '.layanan-surat.form', 'izin-keramaian') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-purple-600 border border-transparent rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                            Buat Surat
                        </a>
                    </div>
                </div>
            </div>

            <!-- Keterangan Usaha -->
            <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-500 rounded-md flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <h3 class="text-lg font-medium text-gray-900">Keterangan Usaha</h3>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Surat keterangan untuk keperluan usaha yang biasanya digunakan untuk keperluan pengajuan kredit
                        atau legalitas usaha.
                    </p>
                    <div class="mt-4">
                        <a href="{{ route(auth()->user()->role . '.layanan-surat.form', 'keterangan-usaha') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            Buat Surat
                        </a>
                    </div>
                </div>
            </div>

            <!-- SKTM -->
            <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-yellow-500 rounded-md flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <h3 class="text-lg font-medium text-gray-900">SKTM</h3>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Surat Keterangan Tidak Mampu diperlukan untuk berbagai keperluan administratif, seperti bantuan
                        sosial, pembebasan biaya sekolah.
                    </p>
                    <div class="mt-4">
                        <a href="{{ route(auth()->user()->role . '.layanan-surat.form', 'sktm') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                            Buat Surat
                        </a>
                    </div>
                </div>
            </div>

            <!-- Belum Menikah -->
            <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-pink-500 rounded-md flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <h3 class="text-lg font-medium text-gray-900">Belum Menikah</h3>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Surat keterangan belum menikah yang biasanya digunakan untuk keperluan administrasi, pendaftaran
                        pernikahan, atau keperluan lainnya.
                    </p>
                    <div class="mt-4">
                        <a href="{{ route(auth()->user()->role . '.layanan-surat.form', 'belum-menikah') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-pink-600 border border-transparent rounded-md hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2">
                            Buat Surat
                        </a>
                    </div>
                </div>
            </div>

            <!-- Keterangan Kematian -->
            <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-gray-600 rounded-md flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <h3 class="text-lg font-medium text-gray-900">Keterangan Kematian</h3>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Surat keterangan kematian yang digunakan untuk keperluan administrasi, klaim asuransi, atau
                        keperluan lainnya terkait kematian.
                    </p>
                    <div class="mt-4">
                        <a href="{{ route(auth()->user()->role . '.layanan-surat.form', 'keterangan-kematian') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-600 border border-transparent rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Buat Surat
                        </a>
                    </div>
                </div>
            </div>

            <!-- Keterangan Kelahiran -->
            <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-indigo-500 rounded-md flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m3 5.197v0a2.25 2.25 0 00-3-2.122 2.25 2.25 0 00-3 2.122v0">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <h3 class="text-lg font-medium text-gray-900">Keterangan Kelahiran</h3>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Surat keterangan kelahiran yang digunakan untuk keperluan administrasi, pembuatan akta
                        kelahiran, atau keperluan lainnya.
                    </p>
                    <div class="mt-4">
                        <a href="{{ route(auth()->user()->role . '.layanan-surat.form', 'keterangan-kelahiran') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Buat Surat
                        </a>
                    </div>
                </div>
            </div>

            <!-- Orang yang Sama -->
            <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-teal-500 rounded-md flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <h3 class="text-lg font-medium text-gray-900">Orang yang Sama</h3>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Surat keterangan orang yang sama yang digunakan untuk menyatakan bahwa dua identitas yang
                        berbeda merujuk pada orang yang sama.
                    </p>
                    <div class="mt-4">
                        <a href="{{ route(auth()->user()->role . '.layanan-surat.form', 'orang-yang-sama') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-teal-600 border border-transparent rounded-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                            Buat Surat
                        </a>
                    </div>
                </div>
            </div>

            <!-- Pindah Keluar -->
            <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-orange-500 rounded-md flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v0"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <h3 class="text-lg font-medium text-gray-900">Pindah Keluar</h3>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Surat keterangan pindah keluar yang digunakan untuk keperluan administrasi kependudukan ketika
                        seseorang pindah dari satu daerah ke daerah lain.
                    </p>
                    <div class="mt-4">
                        <a href="{{ route(auth()->user()->role . '.layanan-surat.form', 'pindah-keluar') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-orange-600 border border-transparent rounded-md hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                            Buat Surat
                        </a>
                    </div>
                </div>
            </div>

            <!-- Domisili Instansi -->
            <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-red-500 rounded-md flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <h3 class="text-lg font-medium text-gray-900">Domisili Instansi</h3>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Surat keterangan domisili instansi yang digunakan untuk menyatakan alamat resmi dari suatu
                        instansi, lembaga, atau organisasi.
                    </p>
                    <div class="mt-4">
                        <a href="{{ route(auth()->user()->role . '.layanan-surat.form', 'domisili-instansi') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            Buat Surat
                        </a>
                    </div>
                </div>
            </div>

            <!-- Domisili Kelompok -->
            <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-cyan-500 rounded-md flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <h3 class="text-lg font-medium text-gray-900">Domisili Kelompok</h3>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Surat keterangan domisili kelompok yang digunakan untuk menyatakan alamat resmi dari suatu
                        kelompok, komunitas, atau perkumpulan.
                    </p>
                    <div class="mt-4">
                        <a href="{{ route(auth()->user()->role . '.layanan-surat.form', 'domisili-kelompok') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-cyan-600 border border-transparent rounded-md hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">
                            Buat Surat
                        </a>
                    </div>
                </div>
            </div>

            <!-- Domisili Orang -->
            <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-emerald-500 rounded-md flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <h3 class="text-lg font-medium text-gray-900">Domisili Orang</h3>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Surat keterangan domisili orang yang digunakan untuk menyatakan tempat tinggal/domisili
                        seseorang untuk keperluan administrasi.
                    </p>
                    <div class="mt-4">
                        <a href="{{ route(auth()->user()->role . '.layanan-surat.form', 'domisili-orang') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-emerald-600 border border-transparent rounded-md hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                            Buat Surat
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
