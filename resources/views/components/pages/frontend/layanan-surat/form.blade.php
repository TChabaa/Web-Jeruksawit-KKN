<x-Layouts.visitor-layout>
    <x-slot:title>Form {{ $title }} | </x-slot:title>

    <div class="container px-4 py-8 mx-auto md:px-8 lg:px-16">
        <div class="mb-6">
            <a href="{{ route('layanan-surat') }}" class="flex items-center text-sm text-gray-600 hover:text-green-new mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
            <h2 class="text-2xl font-semibold text-gray-800 font-inter">Form Pengajuan {{ $title }}</h2>
            <p class="text-gray-600 mt-1 font-inter">Silakan isi formulir di bawah ini dengan data yang benar</p>
        </div>

        <div class="bg-white rounded-lg p-6 shadow-md">
            <form action="{{ route('layanan-surat.submit', $type) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Data Pemohon -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 font-inter">Data Pemohon</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 font-medium outline-none transition focus:border-green-new active:border-green-new disabled:cursor-default disabled:bg-whiter" required>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                            <input type="text" name="nik" id="nik" value="{{ old('nik') }}" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 font-medium outline-none transition focus:border-green-new active:border-green-new disabled:cursor-default disabled:bg-whiter" required>
                            @error('nik')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 font-medium outline-none transition focus:border-green-new active:border-green-new disabled:cursor-default disabled:bg-whiter" required>
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 font-medium outline-none transition focus:border-green-new active:border-green-new disabled:cursor-default disabled:bg-whiter" required>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                            <textarea name="address" id="address" rows="3" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 font-medium outline-none transition focus:border-green-new active:border-green-new disabled:cursor-default disabled:bg-whiter" required>{{ old('address') }}</textarea>
                            @error('address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Data Surat -->
                <div class="pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 font-inter">Data Surat {{ $title }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="purpose" class="block text-sm font-medium text-gray-700 mb-1">Tujuan Pengajuan</label>
                            <input type="text" name="purpose" id="purpose" value="{{ old('purpose') }}" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 font-medium outline-none transition focus:border-green-new active:border-green-new disabled:cursor-default disabled:bg-whiter" required>
                            @error('purpose')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="attachment" class="block text-sm font-medium text-gray-700 mb-1">Lampiran Dokumen Pendukung (PDF/JPG)</label>
                            <input type="file" name="attachment" id="attachment" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 font-medium outline-none transition focus:border-green-new active:border-green-new disabled:cursor-default disabled:bg-whiter">
                            @error('attachment')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan</label>
                            <textarea name="notes" id="notes" rows="3" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 font-medium outline-none transition focus:border-green-new active:border-green-new disabled:cursor-default disabled:bg-whiter">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-new border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Ajukan Permohonan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-Layouts.visitor-layout>
