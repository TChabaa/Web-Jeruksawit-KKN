<x-layouts.dashboard>
    <x-slot:title>Detail Surat {{ $surat->jenisSurat->nama_jenis }}</x-slot:title>

    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Surat
                        {{ $surat->jenisSurat->nama_jenis }}</h1>
                    <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Informasi lengkap permohonan surat</p>
                </div>
                <a href="{{ route(auth()->user()->role . '.layanan-surat') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Status Card -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg mb-6">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Status Permohonan</h3>
                    </div>
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                @php
                                    $statusClass = match ($surat->status) {
                                        'belum_diverifikasi'
                                            => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                        'disetujui'
                                            => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                        'ditolak' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                        default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
                                    };

                                    $statusText = match ($surat->status) {
                                        'belum_diverifikasi' => 'Belum Diverifikasi',
                                        'disetujui' => 'Disetujui',
                                        'ditolak' => 'Ditolak',
                                        default => 'Unknown',
                                    };
                                @endphp
                                <span class="px-3 py-1 text-sm font-medium rounded-full {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </div>
                            <div class="text-sm text-gray-500">
                                Diajukan: {{ $surat->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        @if ($surat->nomor_surat)
                            <div class="mt-4 p-4 bg-green-50 dark:bg-green-900/20 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-green-800 dark:text-green-200">Nomor Surat
                                        </h3>
                                        <div class="mt-1 text-sm text-green-700 dark:text-green-300">
                                            <p>{{ $surat->nomor_surat }}</p>
                                            @if ($surat->tanggal_surat)
                                                <p class="text-xs">Tanggal:
                                                    {{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d/m/Y') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Applicant Information -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg mb-6">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Data Pemohon</h3>
                    </div>
                    <div class="px-6 py-4">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Nama Lengkap</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $surat->pemohon->nama_lengkap }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">NIK</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $surat->pemohon->nik }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Tempat, Tanggal Lahir
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $surat->pemohon->tempat_lahir }},
                                    {{ \Carbon\Carbon::parse($surat->pemohon->tanggal_lahir)->format('d/m/Y') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Jenis Kelamin</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $surat->pemohon->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Agama</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $surat->pemohon->agama }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Status Perkawinan</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $surat->pemohon->status_perkawinan }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Pekerjaan</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $surat->pemohon->pekerjaan }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $surat->pemohon->email }}
                                </dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Alamat</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $surat->pemohon->alamat }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Letter Details -->
                @if ($detail)
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Detail
                                {{ $surat->jenisSurat->nama_jenis }}
                            </h3>
                        </div>
                        <div class="px-6 py-4">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                @switch($surat->jenisSurat->nama_jenis)
                                    @case('SKCK')
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Keperluan</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $detail->keperluan }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Tanggal Mulai
                                                Berlaku</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ \Carbon\Carbon::parse($detail->tanggal_mulai_berlaku)->format('d/m/Y') }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Tanggal Akhir
                                                Berlaku</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ \Carbon\Carbon::parse($detail->tanggal_akhir_berlaku)->format('d/m/Y') }}
                                            </dd>
                                        </div>
                                    @break

                                    @case('Izin Keramaian')
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Keperluan</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $detail->keperluan }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Jenis Hiburan</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->jenis_hiburan }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Tempat Acara</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->tempat_acara }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Hari Acara</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $detail->hari_acara }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Tanggal Acara</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ \Carbon\Carbon::parse($detail->tanggal_acara)->format('d/m/Y') }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Jumlah Undangan
                                            </dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->jumlah_undangan }} orang</dd>
                                        </div>
                                    @break

                                    @case('Keterangan Usaha')
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Mulai Usaha</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ \Carbon\Carbon::parse($detail->mulai_usaha)->format('d/m/Y') }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Jenis Usaha</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->jenis_usaha }}</dd>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Alamat Usaha</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->alamat_usaha }}</dd>
                                        </div>
                                    @break

                                    @case('SKTM')
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Pendidikan</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $detail->pendidikan }}
                                            </dd>
                                        </div>
                                        @if ($detail->penghasilan)
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Penghasilan Per
                                                    Bulan</dt>
                                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">Rp
                                                    {{ number_format($detail->penghasilan, 0, ',', '.') }}</dd>
                                            </div>
                                        @endif
                                        @if ($detail->jumlah_tanggungan)
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Jumlah
                                                    Tanggungan</dt>
                                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                    {{ $detail->jumlah_tanggungan }} orang
                                                </dd>
                                            </div>
                                        @endif
                                    @break

                                    @case('Belum Menikah')
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Keperluan</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $detail->keperluan }}
                                            </dd>
                                        </div>
                                    @break

                                    @case('Keterangan Kematian')
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Nama Almarhum</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->nama_almarhum }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">NIK Almarhum</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->nik_almarhum }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Jenis Kelamin</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Umur</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $detail->umur }}
                                                tahun</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Hari Kematian</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->hari_kematian }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Tanggal Kematian
                                            </dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ \Carbon\Carbon::parse($detail->tanggal_kematian)->format('d/m/Y') }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Tempat Kematian
                                            </dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->tempat_kematian }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Penyebab Kematian
                                            </dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->penyebab_kematian }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Hubungan Pelapor
                                            </dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->hubungan_pelapor }}</dd>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Alamat Almarhum
                                            </dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $detail->alamat }}
                                            </dd>
                                        </div>
                                    @break

                                    @case('Keterangan Kelahiran')
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Nama Anak</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $detail->nama_anak }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Jenis Kelamin</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->jenis_kelamin_anak == 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Hari Lahir</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->hari_lahir }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Tanggal Lahir</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ \Carbon\Carbon::parse($detail->tanggal_lahir)->format('d/m/Y') }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Tempat Lahir</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->tempat_lahir }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Penolong Kelahiran
                                            </dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->penolong_kelahiran }}</dd>
                                        </div>
                                    @break

                                    @case('Orang yang Sama')
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Nama Pertama</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $surat->pemohon->nama_lengkap }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">TTL Pertama</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $surat->pemohon->tempat_lahir }},
                                                {{ \Carbon\Carbon::parse($surat->pemohon->tanggal_lahir)->format('d/m/Y') }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Nama Kedua</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $detail->nama_2 }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">TTL Kedua</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->tempat_lahir_2 }},
                                                {{ \Carbon\Carbon::parse($detail->tanggal_lahir_2)->format('d/m/Y') }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Nama Ayah</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->nama_ayah_2 }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Dasar Dokumen 1
                                            </dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->dasar_dokumen_1 }}</dd>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Dasar Dokumen 2
                                            </dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->dasar_dokumen_2 }}</dd>
                                        </div>
                                    @break

                                    @case('Pindah Keluar')
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Alamat Tujuan</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->alamat_tujuan }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Alasan Pindah</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->alasan_pindah }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Tanggal Pindah
                                            </dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ \Carbon\Carbon::parse($detail->tanggal_pindah)->format('d/m/Y') }}
                                            </dd>
                                        </div>
                                    @break

                                    @case('Domisili Instansi')
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Nama Instansi</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->nama_instansi }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Nama Pimpinan</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->nama_pimpinan }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">NIP Pimpinan</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->nip_pimpinan }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Email Pimpinan
                                            </dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->email_pimpinan }}</dd>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Alamat Instansi
                                            </dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->alamat_instansi }}</dd>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Keterangan Lokasi
                                            </dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->keterangan_lokasi }}</dd>
                                        </div>
                                    @break

                                    @case('Domisili Kelompok')
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Nama Kelompok</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->nama_kelompok }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Ketua</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $detail->ketua }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Email Ketua</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->email_ketua }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Sekretaris</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->sekretaris }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Bendahara</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $detail->bendahara }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Jenis Kelompok
                                            </dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->jenis_kelompok }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Jumlah Anggota
                                            </dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->jumlah_anggota }} orang</dd>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Alamat Kelompok
                                            </dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->alamat_kelompok }}</dd>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Keterangan Lokasi
                                            </dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->keterangan_lokasi }}</dd>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Tujuan Pembentukan
                                            </dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->tujuan_pembentukan }}</dd>
                                        </div>
                                    @break

                                    @case('Domisili Orang')
                                        <div class="sm:col-span-2">
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Keterangan
                                                Domisili</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->keterangan_domisili }}</dd>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Lama Tinggal</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                                {{ $detail->lama_tinggal }}</dd>
                                        </div>
                                    @break

                                    @default
                                        <div class="sm:col-span-2">
                                            <p class="text-sm text-gray-500">Detail tidak tersedia untuk jenis surat ini.</p>
                                        </div>
                                @endswitch
                            </dl>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Actions -->
                @if ($surat->status === 'belum_diverifikasi')
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg mb-6">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Tindakan</h3>
                        </div>
                        <div class="px-6 py-4 space-y-3">
                            <form
                                action="{{ route(auth()->user()->role . '.layanan-surat.status', $surat->id_surat) }}"
                                method="POST" class="space-y-3">
                                @csrf
                                <div>
                                    <label for="status"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                    <select name="status" id="status" required
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                        <option value="">Pilih Status</option>
                                        <option value="disetujui">Setujui</option>
                                        <option value="ditolak">Tolak</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="catatan"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan</label>
                                    <textarea name="catatan" id="catatan" rows="3"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                        placeholder="Catatan tambahan (opsional)"></textarea>
                                </div>
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Update Status
                                </button>
                            </form>
                        </div>
                    </div>
                @elseif ($surat->status === 'disetujui')
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg mb-6">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Unduh Dokumen</h3>
                        </div>
                        <div class="px-6 py-4 space-y-3">
                            <a href="{{ route(auth()->user()->role . '.layanan-surat.download-pdf', $surat->id_surat) }}"
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Unduh PDF
                            </a>
                            <p class="text-xs text-gray-500 text-center">
                                PDF surat telah dikirim ke email pemohon
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Information -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Informasi</h3>
                    </div>
                    <div class="px-6 py-4">
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Jenis Surat</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $surat->jenisSurat->nama_jenis }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Tanggal Pengajuan</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $surat->created_at->format('d/m/Y H:i:s') }}
                                </dd>
                            </div>
                            @if ($surat->created_by)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Dibuat Oleh</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $surat->creator->name ?? 'System' }}
                                    </dd>
                                </div>
                            @endif
                            @if ($surat->updated_at != $surat->created_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Terakhir Diupdate
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $surat->updated_at->format('d/m/Y H:i:s') }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
