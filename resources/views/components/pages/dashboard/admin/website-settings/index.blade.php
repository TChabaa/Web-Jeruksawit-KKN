<x-layouts.dashboard>
    <x-slot:title>Website Settings | </x-slot:title>

    <div
        class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
        <div class="max-w-full overflow-x-auto">
            <div class="mb-6">
                <h3 class="text-xl font-semibold text-black dark:text-white">
                    Website Settings
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Manage website configuration and content settings
                </p>
            </div>

            @php
                $roleName = auth()->user()->role;
                if ($roleName == 'super_admin') {
                    $updateRoute = 'super_admin.website-settings.update';
                } else {
                    $updateRoute = $roleName . '.website-settings.update';
                }
            @endphp

            <form action="{{ route($updateRoute) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Hero Section Settings -->
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                    <h4 class="text-lg font-medium text-black dark:text-white mb-4">
                        Hero Section Settings
                    </h4>

                    <!-- YouTube URL -->
                    <div class="mb-4">
                        <label for="hero_youtube_url"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            YouTube Video URL
                        </label>
                        <input type="url" id="hero_youtube_url" name="hero_youtube_url"
                            value="{{ $settings->get('hero_youtube_url')?->value ?? 'https://www.youtube.com/embed/i4alQJYhKtw?si=jqo-1bsz6RHNOyDP' }}"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                            placeholder="https://www.youtube.com/embed/..." required>
                        <p class="text-xs text-gray-500 mt-1">
                            Enter the YouTube embed URL (should start with https://www.youtube.com/embed/)
                        </p>
                        @error('hero_youtube_url')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- YouTube Title -->
                    <div class="mb-4">
                        <label for="hero_youtube_title"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Video Title
                        </label>
                        <input type="text" id="hero_youtube_title" name="hero_youtube_title"
                            value="{{ $settings->get('hero_youtube_title')?->value ?? 'DESA JERUKSAWIT KAB. KARANGANYAR' }}"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                            placeholder="Enter video title" required>
                        @error('hero_youtube_title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Preview Section -->
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                    <h4 class="text-lg font-medium text-black dark:text-white mb-4">
                        Preview
                    </h4>
                    <div class="aspect-video max-w-md">
                        <iframe id="preview-iframe" loading="lazy"
                            title="{{ $settings->get('hero_youtube_title')?->value ?? 'DESA JERUKSAWIT KAB. KARANGANYAR' }}"
                            class="w-full h-full rounded-lg"
                            src="{{ $settings->get('hero_youtube_url')?->value ?? 'https://www.youtube.com/embed/i4alQJYhKtw?si=jqo-1bsz6RHNOyDP' }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen="">
                        </iframe>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex justify-center rounded-md border border-transparent bg-primary py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                        Update Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Live preview update
        document.getElementById('hero_youtube_url').addEventListener('input', function() {
            const iframe = document.getElementById('preview-iframe');
            const newUrl = this.value;
            if (newUrl && newUrl.includes('youtube.com')) {
                iframe.src = newUrl;
            }
        });

        document.getElementById('hero_youtube_title').addEventListener('input', function() {
            const iframe = document.getElementById('preview-iframe');
            iframe.title = this.value;
        });
    </script>
</x-layouts.dashboard>
