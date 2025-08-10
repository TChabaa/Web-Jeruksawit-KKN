<x-layouts.dashboard>
    <x-slot:title>Tambah Perangkat Desa | </x-slot:title>

    {{-- Breadcrumb --}}
    <nav class="mb-5">
        <ol class="flex items-center gap-2">
            <li>
                <a class="font-medium" href="{{ route(auth()->user()->role . '.dashboard') }}">Dashboard /</a>
            </li>
            <li>
                <a class="font-medium" href="{{ route(auth()->user()->role . '.perangkat-desa.index') }}">Perangkat Desa
                    /</a>
            </li>
            <li class="font-medium text-primary">Tambah Perangkat Desa</li>
        </ol>
    </nav>

    <form action="{{ route(auth()->user()->role . '.perangkat-desa.store') }}" enctype="multipart/form-data"
        method="POST">
        @csrf

        <div class="form-1">
            <div class="">
                <h1 class="mb-6 text-xl font-bold text-black-dashboard dark:text-white-dahsboard">Tambah Perangkat Desa
                </h1>
            </div>

            <div class="px-6 py-6 mb-6 bg-white rounded-lg shadow-lg dark:bg-black">
                <label for="gambar" class="block mb-2 text-sm font-medium text-black dark:text-white">
                    Foto Perangkat Desa
                </label>
                <p class="text-xs font-medium text-gray-400">* Format yang didukung: jpeg, jpg, png</p>
                <p class="text-xs font-medium text-gray-400">* Maksimal ukuran file 4049MB</p>
                <div id="imagePreviewContainer" class="flex flex-wrap gap-5 mt-3"></div>
                <input type="file" accept="image/*" name="gambar" id="gambar" class="mt-3">
                <x-partials.dashboard.input-error :messages="$errors->get('gambar')" />
            </div>

            <div class="px-6 py-6 mb-6 bg-white rounded-lg shadow-lg dark:bg-black">
                <div class="mb-4.5">
                    <label for="nama"
                        class="block mb-3 text-sm font-medium text-black-dashboard dark:text-white-dahsboard">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" required name="nama" autocomplete="nama" maxlength="255"
                        placeholder="Masukan Nama Lengkap" value="{{ old('nama') }}"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black-dashboard outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white-dahsboard dark:focus:border-primary" />
                    <x-partials.dashboard.input-error :messages="$errors->get('nama')" />
                </div>

                <div class="mb-4.5">
                    <label for="jabatan"
                        class="block mb-3 text-sm font-medium text-black-dashboard dark:text-white-dahsboard">
                        Jabatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" required name="jabatan" autocomplete="jabatan" maxlength="255"
                        placeholder="Masukan Jabatan" value="{{ old('jabatan') }}"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black-dashboard outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white-dahsboard dark:focus:border-primary" />
                    <x-partials.dashboard.input-error :messages="$errors->get('jabatan')" />
                </div>
            </div>
        </div>

        <button type="submit"
            class="flex justify-center w-full p-3 font-medium text-white rounded bg-deep-koamaru-600 hover:bg-opacity-90">
            Kirim
        </button>
    </form>

    <script>
        document.getElementById('gambar').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            imagePreviewContainer.innerHTML = ''; // Clear previous image

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-32 h-32 object-cover rounded-lg';
                    imagePreviewContainer.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-layouts.dashboard>
