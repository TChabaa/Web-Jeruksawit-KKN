<div class="p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 dark:bg-boxdark">
    <div class="flex flex-col items-center">
        <div class="p-3 mb-3 rounded-full bg-[#A2AF9B] bg-opacity-10">
            {{ $icon ?? '' }}
        </div>
        <h3 class="mb-2 text-lg font-semibold text-black dark:text-white">{{ $title }}</h3>
        <p class="mb-4 text-sm text-center text-gray-600 dark:text-gray-400">
            {{ $description ?? 'Klik untuk mengajukan surat' }}</p>
        <a href="{{ $url ?? '#' }}"
            class="px-4 py-2 text-sm font-medium text-white transition-colors duration-200 bg-[#A2AF9B] rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
            Ajukan Surat
        </a>
    </div>
</div>
