<x-layouts.visitor-layout>
    <x-slot:title>Form {{ $title }}</x-slot:title>
    <x-slot:pageTitle>Form {{ $title }} - Layanan Surat Online Desa Jeruksawit</x-slot:pageTitle>
    <x-slot:metaDescription>Ajukan permohonan {{ $title }} (Surat Keterangan Tidak Mampu) secara online di Desa
        Jeruksawit, Karanganyar. Untuk bantuan sosial, pembebasan biaya sekolah, dan keperluan administrasi
        lainnya.</x-slot:metaDescription>
    <x-slot:metaKeywords>form sktm jeruksawit, permohonan sktm online, surat keterangan tidak mampu, layanan surat
        jeruksawit, sktm karanganyar, bantuan sosial jeruksawit</x-slot:metaKeywords>
    <x-slot:ogTitle>Form {{ $title }} - Layanan Surat Online Desa Jeruksawit</x-slot:ogTitle>
    <x-slot:ogDescription>Lengkapi formulir permohonan {{ $title }} secara online untuk bantuan sosial dan
        keperluan administrasi lainnya.</x-slot:ogDescription>
    <x-slot:metaRobots>noindex, follow</x-slot:metaRobots>

    @push('structured-data')
        <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "Form {{ $title }}",
        "description": "Formulir permohonan {{ $title }} online untuk masyarakat Desa Jeruksawit yang membutuhkan bantuan sosial.",
        "url": "{{ route('layanan-surat.form', 'sktm') }}",
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
                    "name": "Layanan Surat",
                    "item": "{{ route('layanan-surat') }}"
                },
                {
                    "@type": "ListItem",
                    "position": 3,
                    "name": "Form {{ $title }}",
                    "item": "{{ route('layanan-surat.form', 'sktm') }}"
                }
            ]
        }
    }
    </script>
    @endpush

    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Form {{ $title }}</h1>
                    <p class="mt-2 text-sm text-gray-700">Isi formulir permohonan surat {{ $title }}</p>
                </div>
                <a href="{{ route('layanan-surat') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('layanan-surat.submit', $type) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf

                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Data Pemohon</h3>
                    <p class="mt-1 text-sm text-gray-500">Lengkapi data pribadi pemohon surat</p>
                </div>

                <div class="px-6 pb-4">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Nama Lengkap -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap *</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- NIK -->
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700">
                                NIK (Nomor Induk Kependudukan) *
                            </label>
                            <input type="text" name="nik" id="nik" value="{{ old('nik') }}" required
                                maxlength="16" pattern="[0-9]{16}" placeholder="Masukkan 16 digit NIK sesuai KTP"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                oninput="validateNIK(this)">
                            <p class="mt-1 text-xs text-gray-500">
                                Contoh: 3313110905810002 (16 digit angka sesuai KTP)
                            </p>
                            @error('nik')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor KK -->
                        <div>
                            <label for="nomor_kk" class="block text-sm font-medium text-gray-700">
                                Nomor Kartu Keluarga (KK) *
                            </label>
                            <input type="text" name="nomor_kk" id="nomor_kk" value="{{ old('nomor_kk') }}" required
                                maxlength="16" pattern="[0-9]{16}" placeholder="Masukkan 16 digit nomor KK"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                oninput="validateKK(this)">
                            <p class="mt-1 text-xs text-gray-500">
                                Contoh: 3313131809130005 (16 digit angka sesuai Kartu Keluarga)
                            </p>
                            @error('nomor_kk')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tempat Lahir -->
                        <div>
                            <label for="tempat_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir
                                *</label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir"
                                value="{{ old('tempat_lahir') }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            @error('tempat_lahir')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir
                                *</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                value="{{ old('tanggal_lahir') }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            @error('tanggal_lahir')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin
                                *</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                            @error('jenis_kelamin')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Agama -->
                        <div>
                            <label for="agama" class="block text-sm font-medium text-gray-700">Agama *</label>
                            <select name="agama" id="agama" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                <option value="">Pilih Agama</option>
                                <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen
                                </option>
                                <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik
                                </option>
                                <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu
                                </option>
                            </select>
                            @error('agama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status Perkawinan -->
                        <div>
                            <label for="status_perkawinan" class="block text-sm font-medium text-gray-700">Status
                                Perkawinan *</label>
                            <select name="status_perkawinan" id="status_perkawinan" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                <option value="">Pilih Status</option>
                                <option value="Belum Kawin"
                                    {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin
                                </option>
                                <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>
                                    Kawin</option>
                                <option value="Cerai Hidup"
                                    {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup
                                </option>
                                <option value="Cerai Mati"
                                    {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati
                                </option>
                            </select>
                            @error('status_perkawinan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pekerjaan -->
                        <div>
                            <label for="pekerjaan" class="block text-sm font-medium text-gray-700">Pekerjaan *</label>
                            <input type="text" name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan') }}"
                                required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            @error('pekerjaan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon
                                *</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="mt-6">
                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat Lengkap *</label>
                        <textarea name="address" id="address" rows="3" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Detail SKTM Section -->
                <div class="px-6 py-4 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Detail {{ $title }}</h3>
                    <p class="mt-1 text-sm text-gray-500">Informasi khusus untuk permohonan {{ $title }}</p>
                </div>

                <div class="px-6 pb-4">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Pendidikan -->
                        <div class="sm:col-span-2">
                            <label for="pendidikan" class="block text-sm font-medium text-gray-700">Pendidikan
                                Terakhir
                                *</label>
                            <select name="pendidikan" id="pendidikan" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                <option value="">Pilih Pendidikan Terakhir</option>
                                <option value="Tidak Sekolah"
                                    {{ old('pendidikan') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah
                                </option>
                                <option value="SD" {{ old('pendidikan') == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ old('pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA/SMK" {{ old('pendidikan') == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK
                                </option>
                                <option value="Diploma" {{ old('pendidikan') == 'Diploma' ? 'selected' : '' }}>Diploma
                                </option>
                                <option value="Sarjana" {{ old('pendidikan') == 'Sarjana' ? 'selected' : '' }}>Sarjana
                                </option>
                                <option value="Magister" {{ old('pendidikan') == 'Magister' ? 'selected' : '' }}>
                                    Magister
                                </option>
                                <option value="Doktor" {{ old('pendidikan') == 'Doktor' ? 'selected' : '' }}>Doktor
                                </option>
                            </select>
                            @error('pendidikan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Penghasilan -->
                        <div>
                            <label for="penghasilan" class="block text-sm font-medium text-gray-700">Penghasilan Per
                                Bulan</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="penghasilan" id="penghasilan"
                                    value="{{ old('penghasilan') }}" min="0" placeholder="0"
                                    class="pl-8 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            </div>
                            @error('penghasilan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jumlah Tanggungan -->
                        <div>
                            <label for="jumlah_tanggungan" class="block text-sm font-medium text-gray-700">Jumlah
                                Tanggungan Keluarga</label>
                            <input type="number" name="jumlah_tanggungan" id="jumlah_tanggungan"
                                value="{{ old('jumlah_tanggungan') }}" min="0"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            @error('jumlah_tanggungan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <!-- Additional Information Section -->
                <div class="px-6 py-4 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Tambahan</h3>
                    <p class="mt-1 text-sm text-gray-500">Informasi pendukung untuk permohonan surat</p>
                </div>

                <div class="px-6 pb-6">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Purpose -->
                        <div>
                            <label for="purpose" class="block text-sm font-medium text-gray-700">Tujuan/Maksud
                                Pengajuan *</label>
                            <input type="text" name="purpose" id="purpose" value="{{ old('purpose') }}"
                                required placeholder="Contoh: Bantuan sosial, pembebasan biaya sekolah, dll"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            @error('purpose')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Catatan
                                Tambahan</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 rounded-b-lg">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('layanan-surat') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Ajukan Permohonan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // NIK and KK validation functions
            function validateNIK(input) {
                const value = input.value.replace(/\D/g, ''); // Remove non-digits
                input.value = value; // Update input value

                const warningElement = input.parentNode.querySelector('.nik-warning');
                if (warningElement) {
                    warningElement.remove();
                }

                if (value.length > 0 && value.length < 16) {
                    showValidationWarning(input, 'NIK harus terdiri dari 16 digit angka', 'nik-warning');
                } else if (value.length === 16) {
                    removeValidationWarning(input, 'nik-warning');
                }
            }

            function validateKK(input) {
                const value = input.value.replace(/\D/g, ''); // Remove non-digits
                input.value = value; // Update input value

                const warningElement = input.parentNode.querySelector('.kk-warning');
                if (warningElement) {
                    warningElement.remove();
                }

                if (value.length > 0 && value.length < 16) {
                    showValidationWarning(input, 'Nomor KK harus terdiri dari 16 digit angka', 'kk-warning');
                } else if (value.length === 16) {
                    removeValidationWarning(input, 'kk-warning');
                }
            }

            function showValidationWarning(input, message, className) {
                const warning = document.createElement('p');
                warning.className = `mt-1 text-sm text-orange-600 ${className}`;
                warning.textContent = message;
                input.parentNode.appendChild(warning);
            }

            function removeValidationWarning(input, className) {
                const warning = input.parentNode.querySelector(`.${className}`);
                if (warning) {
                    warning.remove();
                }
            }
        </script>
    @endpush
</x-layouts.visitor-layout>
