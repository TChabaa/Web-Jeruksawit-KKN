<script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>
<x-layouts.dashboard>
    {{-- Breadcrumb --}}
    <nav class="mb-5">
        <ol class="flex items-center gap-2">
            <li>
                <a class="font-medium" href="{{ route(auth()->user()->role . '.dashboard') }}">Dashboard /</a>
            </li>
            <li>
                <a class="font-medium" href="{{ route(auth()->user()->role . '.articles.index') }}">Artikel /</a>
            </li>
            <li class="font-medium text-primary">Ubah Artikel</li>
        </ol>
    </nav>



    <form action="{{ route(strtolower(auth()->user()->role) . '.articles.update', [$article->id]) }}"
        enctype="multipart/form-data" method="POST" novalidate>
        @csrf
        @method('PUT')
        <div class="form-1">
            <h1 class="mb-6 text-xl font-bold text-black-dashboard dark:text-white-dahsboard">Ubah Artikel</h1>



            <div class="px-6 py-6 mb-6 bg-white rounded-lg shadow-lg dark:bg-black">
                @if (auth()->user()->role != 'writer')
                    <div class="mb-4.5">
                        <label for="author" class="block mb-3 text-sm font-medium text-black dark:text-white">
                            Pembuat Artikel <span class="text-red-500">*</span>
                        </label>
                        <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent dark:bg-form-input">
                            <select required id="author" name="writer"
                                class="relative z-20 w-full px-5 py-3 transition bg-transparent border border-black rounded outline-none appearance-none focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                :class="isOptionSelected && 'text-black dark:text-white'"
                                @change="isOptionSelected = true">
                                <option value="" hidden class="text-body">
                                    Pilih Pembuat Artikel
                                </option>
                                @forelse ($admins as $admin)
                                    <option value="{{ $admin->id }}" class="text-body"
                                        {{ $article->author_id == $admin->id ? 'selected' : '' }}>
                                        {{ $admin->name }}</option>
                                @empty
                                    <option value="" class="text-body" selected>Belum ada Pembuat Artikel
                                    </option>
                                @endforelse
                            </select>
                            <x-partials.dashboard.input-error :messages="$errors->get('author')" />
                        </div>
                    </div>
                @endif
                <div class="mb-4.5">
                    <label for="title"
                        class="block mb-3 text-sm font-medium text-black-dashboard dark:text -white-dahsboard">
                        Judul <span class="text-red-500">*</span>
                    </label>
                    <input type="text" required name="title" autocomplete="title" maxlength="75"
                        placeholder="Masukan Judul" value="{{ $article->title }}"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black-dashboard outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white-dahsboard dark:focus:border-primary">
                    <x-partials.dashboard.input-error :messages="$errors->get('title')" />
                </div>

                <div class="mb-4.5">
                    <label for="content"
                        class="block mb-3 text-sm font-medium text-black-dashboard dark:text-white-dahsboard">
                        Konten <span class="text-red-500">*</span>
                    </label>
                    <textarea rows="5" cols="30" id="editor" required name="content" placeholder="Masukan Konten"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black-dashboard outline-none transition  active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white-dahsboard ">{{ $article->content }}</textarea>
                    <x-partials.dashboard.input-error :messages="$errors->get('content')" />
                </div>
            </div>

            <button type="submit"
                class="flex justify-center w-full p-3 font-medium text-white rounded bg-deep-koamaru-600 hover:bg-opacity-90">
                Kirim
            </button>
        </div>
    </form>

    <div class="text-center text-black dark:text-white-dahsboard">
        <h2>Galeri</h2>
    </div>

    <div class="mb-4">
        <button data-modal-target="crud-modal-4" data-modal-toggle="crud-modal-4"
            class="px-4 py-2 text-white rounded-md bg-deep-koamaru-600">Tambah
            Galeri</button>
    </div>

    {{-- Form Galeri --}}
    @foreach ($article->gambar_articles as $gambar_article)
        <div class="py-2 border-b-2 border-stone-200">
            <div class="flex items-center justify-between ">
                <div class="object-contain w-40 overflow-hidden rounded-md">
                    <a href="{{ Storage::url($gambar_article->image_url) }}" target="_blank">
                        <img class="w-full" src="{{ Storage::url($gambar_article->image_url) }}"
                            alt="Gambar Wisata">
                    </a>
                </div>
                <form
                    action="{{ route(auth()->user()->role . '.articles.destroyGambar', [$article->id, $gambar_article->id]) }}"
                    method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 text-white rounded-md bg-danger ">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    @endforeach

    <!-- Main modal -->
    <div id="crud-modal-4" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Tambah Galeri
                    </h3>
                    <button type="button"
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="crud-modal-4">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form
                    action="{{ route(auth()->user()->role . '.articles.addGambar', $article->id) }}"
                    method="POST" enctype="multipart/form-data" class="p-4 md:p-5">
                    @csrf
                    @method('POST')

                    <div class="px-6 py-6 mb-6 bg-white rounded-lg dark:bg-black">
                        <label for="gambar_articles"
                            class="block mb-2 text-sm font-medium text-black dark:text-white">
                            Masukan Foto <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs font-medium text-red-500">* Menambahkan foto bisa lebih dari
                            satu</p>
                        <p class="text-xs font-medium text-red-500">* Pastikan file bertipe jpeg, jpg,
                            png</p>
                        <p class="text-xs font-medium text-red-500">* Maksimal file 1MB</p>
                        <input type="file" required multiple accept="image/*" name="gambar_articles[]"
                            id="gambar_articles" class="mt-3">
                        <x-partials.dashboard.input-error :messages="$errors->get('gambar_articles.')" />
                    </div>
                    <div class="pb-4 text-center ">

                        <button type="submit"
                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="w-5 h-5 me-1 -ms-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            const files = event.target.files;
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            imagePreviewContainer.innerHTML = ''; // Clear previous images

            for (const file of files) {
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

    <script>
        CKEDITOR.replace('content', {
            versionCheck: false,
            toolbar: [{
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
                },
                {
                    name: 'styles',
                    items: ['Format']
                },
                {
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline', 'Strike']
                },
                {
                    name: 'tools',
                    items: ['Maximize']
                }
            ]
        }); // by name bukan id CKeditor 4
    </script>
</x-layouts.dashboard>
