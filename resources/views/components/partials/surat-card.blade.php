<div class="p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 dark:bg-boxdark">
    <div class="flex flex-col items-center">
        <div class="p-3 mb-3 rounded-full bg-green-new bg-opacity-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-new" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <h3 class="mb-2 text-lg font-semibold text-black dark:text-white">{{ $title }}</h3>
        <p class="mb-4 text-sm text-center text-gray-600 dark:text-gray-400">{{ $description ?? 'Klik untuk mengajukan surat' }}</p>
        <a href="{{ $url ?? '#' }}" class="px-4 py-2 text-sm font-medium text-white transition-colors duration-200 bg-green-new rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
            Ajukan Surat
        </a>
    </div>
</div>
