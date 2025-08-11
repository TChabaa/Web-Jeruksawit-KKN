<x-layouts.dashboard>
    <x-slot:title>Form {{ $title }}</x-slot:title>

    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Form {{ $title }}</h1>
                    <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Isi formulir permohonan surat {{ $title }}</p>
                </div>
                <a href="{{ route(auth()->user()->role . '.layanan-surat.create') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <form action="{{ route(auth()->user()->role . '.layanan-surat.submit', $type) }}" method="POST"
                enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Data Pemohon</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Lengkapi data pribadi pemohon surat</p>
                </div>

                <div class="px-6 pb-4">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Nama Lengkap -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama Lengkap *</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- NIK -->
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700 dark:text-gray-200">NIK *</label>
                            <input type="text" name="nik" id="nik" value="{{ old('nik') }}" required
                                maxlength="16" pattern="[0-9]{16}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('nik')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor KK -->
                        <div>
                            <label for="nomor_kk" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nomor Kartu Keluarga
                                *</label>
                            <input type="text" name="nomor_kk" id="nomor_kk" value="{{ old('nomor_kk') }}" required
                                maxlength="16" pattern="[0-9]{16}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('nomor_kk')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tempat Lahir -->
                        <div>
                            <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tempat Lahir
                                *</label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir"
                                value="{{ old('tempat_lahir') }}" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('tempat_lahir')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal Lahir
                                *</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                value="{{ old('tanggal_lahir') }}" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('tanggal_lahir')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Jenis Kelamin
                                *</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
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
                            <label for="agama" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Agama *</label>
                            <select name="agama" id="agama" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
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
                            <label for="status_perkawinan" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Status
                                Perkawinan *</label>
                            <select name="status_perkawinan" id="status_perkawinan" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
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
                            <label for="pekerjaan" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Pekerjaan *</label>
                            <input type="text" name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan') }}"
                                required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('pekerjaan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email *</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nomor Telepon
                                *</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="mt-6">
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Alamat Lengkap *</label>
                        <textarea name="address" id="address" rows="3" required
                            class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Detail Izin Keramaian Section -->
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Detail {{ $title }}</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Informasi khusus untuk permohonan {{ $title }}</p>
                </div>

                <div class="px-6 pb-4">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Keperluan -->
                        <div class="sm:col-span-2">
                            <label for="keperluan" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Keperluan *</label>
                            <input type="text" name="keperluan" id="keperluan" value="{{ old('keperluan') }}"
                                required placeholder="Contoh: Hajatan pernikahan, konser musik, dll"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('keperluan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Hiburan -->
                        <div>
                            <label for="jenis_hiburan" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Jenis Hiburan
                                *</label>
                            <input type="text" name="jenis_hiburan" id="jenis_hiburan"
                                value="{{ old('jenis_hiburan') }}" required
                                placeholder="Contoh: Live music, DJ, orkes, dll"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('jenis_hiburan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tempat Acara -->
                        <div>
                            <label for="tempat_acara" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tempat Acara
                                *</label>
                            <input type="text" name="tempat_acara" id="tempat_acara"
                                value="{{ old('tempat_acara') }}" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('tempat_acara')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hari Acara -->
                        <div>
                            <label for="hari_acara" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Hari Acara
                                *</label>
                            <select name="hari_acara" id="hari_acara" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">Pilih Hari</option>
                                <option value="Senin" {{ old('hari_acara') == 'Senin' ? 'selected' : '' }}>Senin
                                </option>
                                <option value="Selasa" {{ old('hari_acara') == 'Selasa' ? 'selected' : '' }}>Selasa
                                </option>
                                <option value="Rabu" {{ old('hari_acara') == 'Rabu' ? 'selected' : '' }}>Rabu
                                </option>
                                <option value="Kamis" {{ old('hari_acara') == 'Kamis' ? 'selected' : '' }}>Kamis
                                </option>
                                <option value="Jumat" {{ old('hari_acara') == 'Jumat' ? 'selected' : '' }}>Jumat
                                </option>
                                <option value="Sabtu" {{ old('hari_acara') == 'Sabtu' ? 'selected' : '' }}>Sabtu
                                </option>
                                <option value="Minggu" {{ old('hari_acara') == 'Minggu' ? 'selected' : '' }}>Minggu
                                </option>
                            </select>
                            @error('hari_acara')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Acara -->
                        <div>
                            <label for="tanggal_acara" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal Acara
                                *</label>
                            <input type="date" name="tanggal_acara" id="tanggal_acara"
                                value="{{ old('tanggal_acara') }}" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('tanggal_acara')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jumlah Undangan -->
                        <div>
                            <label for="jumlah_undangan" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Jumlah
                                Undangan *</label>
                            <input type="number" name="jumlah_undangan" id="jumlah_undangan"
                                value="{{ old('jumlah_undangan') }}" required min="1"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('jumlah_undangan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Information Section -->
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Informasi Tambahan</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Informasi pendukung untuk permohonan surat</p>
                </div>

                <div class="px-6 pb-6">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Purpose -->
                        <div>
                            <label for="purpose" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tujuan/Maksud
                                Pengajuan *</label>
                            <input type="text" name="purpose" id="purpose" value="{{ old('purpose') }}"
                                required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('purpose')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Catatan
                                Tambahan</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 rounded-b-lg">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route(auth()->user()->role . '.layanan-surat.create') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
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
            document.addEventListener('DOMContentLoaded', function() {
                // Set minimum date for event date to today
                const today = new Date().toISOString().split('T')[0];
                document.getElementById('tanggal_acara').min = today;
            });
        </script>
    @endpush
</x-layouts.dashboard>
