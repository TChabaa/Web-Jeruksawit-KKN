<x-Layouts.visitor-layout>

    <x-slot:title>Layanan Surat Menyurat | </x-slot:title>

    <section class="px-6 mx-auto py-30 max-w-7xl font-inter">
        <div class="mb-10 text-center">
            <h1 class="mb-4 text-3xl font-bold text-gray-800 md:text-4xl">Layanan Surat Menyurat</h1>
            <p class="max-w-3xl mx-auto text-gray-600">
                Silakan pilih jenis surat yang Anda butuhkan di bawah ini. Setiap jenis surat akan meminta beberapa
                informasi dasar dan dokumen
                pendukung yang diperlukan. Setelah mengisi formulir, surat akan langsung ke email anda sesuai format
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
                url="{{ route('layanan-surat.form', 'skck') }}" />

            <!-- Izin Keramaian -->
            <x-partials.surat-card title="Izin Keramaian"
                description="Surat izin untuk mengadakan acara/keramaian seperti hajatan, konser, atau acara lainnya yang melibatkan banyak orang."
                url="{{ route('layanan-surat.form', 'izin-keramaian') }}" />

            <!-- Keterangan Usaha -->
            <x-partials.surat-card title="Keterangan Usaha"
                description="Surat keterangan untuk keperluan usaha yang biasanya digunakan untuk keperluan pengajuan kredit atau legalitas usaha."
                url="{{ route('layanan-surat.form', 'keterangan-usaha') }}" />

            <!-- SKTM -->
            <x-partials.surat-card title="SKTM"
                description="Surat Keterangan Tidak Mampu diperluakan untuk berbagai keperluan administratif, seperti bantuan sosial, pembebasan biaya sekolah, atau keperluan lainnya."
                url="{{ route('layanan-surat.form', 'sktm') }}" />

            <!-- Belum Menikah -->
            <x-partials.surat-card title="Belum Menikah"
                description="Surat keterangan belum menikah yang biasanya digunakan untuk keperluan administrasi, pendaftaran pernikahan, atau keperluan lainnya."
                url="{{ route('layanan-surat.form', 'belum-menikah') }}" />

            <!-- Keterangan Kematian -->
            <x-partials.surat-card title="Keterangan Kematian"
                description="Surat keterangan kematian yang digunakan untuk keperluan administrasi, klaim asuransi, atau keperluan lainnya terkait dengan kematian seseorang."
                url="{{ route('layanan-surat.form', 'keterangan-kematian') }}" />

            <!-- Keterangan Kelahiran -->
            <x-partials.surat-card title="Keterangan Kelahiran"
                description="Surat keterangan kelahiran yang digunakan untuk keperluan administrasi, pembuatan akta kelahiran, atau keperluan lainnya terkait dengan kelahiran."
                url="{{ route('layanan-surat.form', 'keterangan-kelahiran') }}" />

            <!-- Orang yang Sama -->
            <x-partials.surat-card title="Orang yang Sama"
                description="Surat keterangan orang yang sama yang digunakan untuk menyatakan bahwa dua identitas yang berbeda merujuk pada orang yang sama."
                url="{{ route('layanan-surat.form', 'orang-yang-sama') }}" />

            <!-- Pindah Keluar -->
            <x-partials.surat-card title="Pindah Keluar"
                description="Surat keterangan pindah keluar yang digunakan untuk keperluan administrasi kependudukan ketika seseorang pindah dari satu daerah ke daerah lain."
                url="{{ route('layanan-surat.form', 'pindah-keluar') }}" />

            <!-- Domisili Instansi -->
            <x-partials.surat-card title="Domisili Instansi"
                description="Surat keterangan domisili instansi yang digunakan untuk menyatakan alamat resmi dari suatu instansi, lembaga, atau organisasi."
                url="{{ route('layanan-surat.form', 'domisili-instansi') }}" />

            <!-- Domisili Kelompok -->
            <x-partials.surat-card title="Domisili Kelompok"
                description="Surat keterangan domisili kelompok yang digunakan untuk menyatakan alamat resmi dari suatu kelompok, komunitas, atau perkumpulan."
                url="{{ route('layanan-surat.form', 'domisili-kelompok') }}" />

            <!-- Domisili Orang -->
            <x-partials.surat-card title="Domisili Orang"
                description="Surat keterangan domisili orang yang digunakan untuk menyatakan tempat tinggal/domisili seseorang untuk keperluan administrasi."
                url="{{ route('layanan-surat.form', 'domisili-orang') }}" />
        </div>
    </section>
</x-Layouts.visitor-layout>
