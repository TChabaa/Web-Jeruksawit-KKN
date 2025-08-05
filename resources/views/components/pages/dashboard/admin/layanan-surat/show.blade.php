<x-layouts.dashboard>
    <x-slot:title>Detail Surat {{ $surat->jenisSurat->nama_jenis }}</x-slot:title>

    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Detail Surat {{ $surat->jenisSurat->nama_jenis }}</h1>
                    <p class="mt-2 text-sm text-gray-700">Informasi lengkap permohonan surat</p>
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

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Status Card -->
                <div class="bg-white shadow rounded-lg mb-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Status Permohonan</h3>
                    </div>
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                @php
                                    $statusClass = match ($surat->status) {
                                        'belum_diverifikasi' => 'bg-yellow-100 text-yellow-800',
                                        'disetujui' => 'bg-green-100 text-green-800',
                                        'ditolak' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800',
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
                            <div class="mt-4 p-4 bg-green-50 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-green-800">Nomor Surat</h3>
                                        <div class="mt-1 text-sm text-green-700">
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
                <div class="bg-white shadow rounded-lg mb-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Data Pemohon</h3>
                    </div>
                    <div class="px-6 py-4">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $surat->pemohon->nama_lengkap }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">NIK</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $surat->pemohon->nik }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tempat, Tanggal Lahir</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $surat->pemohon->tempat_lahir }},
                                    {{ \Carbon\Carbon::parse($surat->pemohon->tanggal_lahir)->format('d/m/Y') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $surat->pemohon->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Agama</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $surat->pemohon->agama }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status Perkawinan</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $surat->pemohon->status_perkawinan }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Pekerjaan</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $surat->pemohon->pekerjaan }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $surat->pemohon->email }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $surat->pemohon->alamat }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Letter Details -->
                @if ($detail)
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Detail {{ $surat->jenisSurat->nama_jenis }}
                            </h3>
                        </div>
                        <div class="px-6 py-4">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                @switch($surat->jenisSurat->nama_jenis)
                                    @case('SKCK')
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Keperluan</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $detail->keperluan }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Tanggal Mulai Berlaku</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($detail->tanggal_mulai_berlaku)->format('d/m/Y') }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Tanggal Akhir Berlaku</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($detail->tanggal_akhir_berlaku)->format('d/m/Y') }}
                                            </dd>
                                        </div>
                                    @break

                                    @case('Izin Keramaian')
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Keperluan</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $detail->keperluan }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Jenis Hiburan</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $detail->jenis_hiburan }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Tempat Acara</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $detail->tempat_acara }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Hari Acara</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $detail->hari_acara }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Tanggal Acara</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($detail->tanggal_acara)->format('d/m/Y') }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Jumlah Undangan</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $detail->jumlah_undangan }} orang</dd>
                                        </div>
                                    @break

                                    @case('Keterangan Usaha')
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Mulai Usaha</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($detail->mulai_usaha)->format('d/m/Y') }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Jenis Usaha</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $detail->jenis_usaha }}</dd>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <dt class="text-sm font-medium text-gray-500">Alamat Usaha</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $detail->alamat_usaha }}</dd>
                                        </div>
                                    @break

                                    @case('SKTM')
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Pendidikan</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $detail->pendidikan }}</dd>
                                        </div>
                                    @break

                                    @case('Belum Menikah')
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Keperluan</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $detail->keperluan }}</dd>
                                        </div>
                                    @break

                                    @case('Keterangan Kematian')
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Nama Almarhum</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $detail->nama_almarhum }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">NIK Almarhum</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $detail->nik_almarhum }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                {{ $detail->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Umur</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $detail->umur }} tahun</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Hari Kematian</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $detail->hari_kematian }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Tanggal Kematian</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($detail->tanggal_kematian)->format('d/m/Y') }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Tempat Kematian</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $detail->tempat_kematian }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Penyebab Kematian</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $detail->penyebab_kematian }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Hubungan Pelapor</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $detail->hubungan_pelapor }}</dd>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <dt class="text-sm font-medium text-gray-500">Alamat Almarhum</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $detail->alamat }}</dd>
                                        </div>
                                    @break

                                    @case('Keterangan Kelahiran')
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Nama Anak</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $detail->nama_anak }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                {{ $detail->jenis_kelamin_anak == 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Hari Lahir</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $detail->hari_lahir }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Tanggal Lahir</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($detail->tanggal_lahir)->format('d/m/Y') }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Tempat Lahir</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $detail->tempat_lahir }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Penolong Kelahiran</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $detail->penolong_kelahiran }}</dd>
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
                    <div class="bg-white shadow rounded-lg mb-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Tindakan</h3>
                        </div>
                        <div class="px-6 py-4 space-y-3">
                            <form
                                action="{{ route(auth()->user()->role . '.layanan-surat.status', $surat->id_surat) }}"
                                method="POST" class="space-y-3">
                                @csrf
                                <div>
                                    <label for="status"
                                        class="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="status" id="status" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                        <option value="">Pilih Status</option>
                                        <option value="disetujui">Setujui</option>
                                        <option value="ditolak">Tolak</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="catatan"
                                        class="block text-sm font-medium text-gray-700">Catatan</label>
                                    <textarea name="catatan" id="catatan" rows="3"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                        placeholder="Catatan tambahan (opsional)"></textarea>
                                </div>
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Update Status
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- Information -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Informasi</h3>
                    </div>
                    <div class="px-6 py-4">
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Jenis Surat</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $surat->jenisSurat->nama_jenis }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tanggal Pengajuan</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $surat->created_at->format('d/m/Y H:i:s') }}
                                </dd>
                            </div>
                            @if ($surat->created_by)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Dibuat Oleh</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $surat->creator->name ?? 'System' }}
                                    </dd>
                                </div>
                            @endif
                            @if ($surat->updated_at != $surat->created_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Terakhir Diupdate</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
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
