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
            <li class="font-medium text-primary">Tambah Artikel</li>
        </ol>
    </nav>

    <form action="{{ route(strtolower(auth()->user()->role) . '.articles.store') }}" enctype="multipart/form-data"
        method="POST">
        @csrf
        <div class="form-1">
            <h1 class="mb-6 text-xl font-bold text-black-dashboard dark:text-white-dahsboard">Tambah Artikel</h1>

            <div class="px-6 py-6 mb-6 bg-white rounded-lg shadow-lg dark:bg-black">
                <label for="gambar_article" class="block mb-2 text-sm font-medium text-black dark:text-white">
                    Masukan Foto <span class="text-red-500">*</span>
                </label>
                <p class="text-xs font-medium text-gray-400">* Menambahkan foto bisa lebih dari satu</p>
                <p class="text-xs font-medium text-gray-400">* Pastikan file bertipe jpeg, jpg, png</p>
                <p class="text-xs font-medium text-gray-400">* Maksimal file 4049MB</p>
                <div id="imagePreviewContainer" class="flex flex-wrap gap-5 mt-3"></div>
                <input type="file" required multiple accept="image/*" name="gambar_articles[]" id="gambar_articles"
                    class="mt-3">
                <x-partials.dashboard.input-error :messages="$errors->get('gambar_articles.')" />
            </div>

            <div class="px-6 py-6 mb-6 bg-white rounded-lg shadow-lg dark:bg-black">
                <div class="mb-4.5">
                    <label for="title"
                        class="block mb-3 text-sm font-medium text-black-dashboard dark:text-white-dahsboard">
                        Judul <span class="text-red-500">*</span>
                    </label>
                    <input type="text" required name="title" autocomplete="title" maxlength="75"
                        placeholder="Masukan Judul" value="{{ old('title') }}"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black-dashboard outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white-dahsboard dark:focus:border-primary">
                    <x-partials.dashboard.input-error :messages="$errors->get('title')" />
                </div>

                <div class="mb-4.5">
                    <label for="content"
                        class="block mb-3 text-sm font-medium text-black-dashboard dark:text-white-dahsboard">
                        Konten <span class="text-red-500">*</span>
                    </label>
                    <textarea rows="5" cols="30" id="content" required name="content" placeholder="Masukan Konten"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black-dashboard outline-none transition  active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white-dahsboard ">{{ old('content') }}</textarea>
                    <x-partials.dashboard.input-error :messages="$errors->get('content')" />
                </div>
            </div>

            <button type="submit"
                class="flex justify-center w-full p-3 font-medium text-white rounded bg-deep-koamaru-600 hover:bg-opacity-90">
                Kirim
            </button>
        </div>
    </form>


</x-layouts.dashboard>
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
<script>
    // Cache for storing selected files
    let selectedFiles = [];
    let fileCounter = 0;

    document.getElementById('gambar_articles').addEventListener('change', function(event) {
        const newFiles = Array.from(event.target.files);
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');

        // Add new files to the cache
        newFiles.forEach(file => {
            const fileId = 'file_' + fileCounter++;
            selectedFiles.push({
                id: fileId,
                file: file
            });

            // Create preview for new file
            const reader = new FileReader();
            reader.onload = function(e) {
                const imageWrapper = document.createElement('div');
                imageWrapper.className = 'relative';
                imageWrapper.setAttribute('data-file-id', fileId);

                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-32 h-32 object-cover rounded-lg';

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className =
                    'absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600';
                removeBtn.innerHTML = '×';
                removeBtn.onclick = function() {
                    removeFile(fileId);
                };

                imageWrapper.appendChild(img);
                imageWrapper.appendChild(removeBtn);
                imagePreviewContainer.appendChild(imageWrapper);
            }
            reader.readAsDataURL(file);
        });

        // Update the file input with all selected files
        updateFileInput();
    });

    function removeFile(fileId) {
        // Remove from cache
        selectedFiles = selectedFiles.filter(item => item.id !== fileId);

        // Remove preview
        const previewElement = document.querySelector(`[data-file-id="${fileId}"]`);
        if (previewElement) {
            previewElement.remove();
        }

        // Update file input
        updateFileInput();
    }

    function updateFileInput() {
        const fileInput = document.getElementById('gambar_articles');
        const dataTransfer = new DataTransfer();

        // Add all cached files to DataTransfer
        selectedFiles.forEach(item => {
            dataTransfer.items.add(item.file);
        });

        // Update the file input
        fileInput.files = dataTransfer.files;
    }
</script>
