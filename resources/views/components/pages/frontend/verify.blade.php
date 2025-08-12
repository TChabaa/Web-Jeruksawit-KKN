<x-layouts.visitor-layout>
    <div class="max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <!-- Header -->
        <div class="border-b pb-4 mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Verifikasi Surat Resmi</h1>
            <p class="text-gray-600">Sistem verifikasi surat resmi Desa Jeruksawit</p>
        </div>

        <!-- Surat Information Card -->
        <div class="bg-gradient-to-r from-green-50 to-blue-50 border border-green-200 rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Informasi Surat Terverifikasi
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-3">
                    <div>
                        <span class="font-medium text-gray-700">Nomor Surat:</span>
                        <span class="ml-2 text-gray-900 font-semibold">{{ $surat->nomor_surat }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Jenis Surat:</span>
                        <span class="ml-2 text-gray-900 font-semibold">{{ $surat->jenisSurat->nama_jenis }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Tanggal Terbit:</span>
                        <span
                            class="ml-2 text-gray-900 font-semibold">{{ $surat->tanggal_surat ? $surat->tanggal_surat->format('d F Y') : 'Belum ditetapkan' }}</span>
                    </div>
                </div>
                <div class="space-y-3">
                    <div>
                        <span class="font-medium text-gray-700">Nama Pemohon:</span>
                        <span class="ml-2 text-gray-900 font-semibold">{{ $surat->pemohon->nama_lengkap }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">NIK:</span>
                        <span class="ml-2 text-gray-900 font-semibold">{{ $surat->pemohon->nik }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Status:</span>
                        <span
                            class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            ✓ Surat Valid
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- PDF Viewer Section -->
        <div class="border-t pt-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Dokumen Asli
                </h2>
                <div class="text-sm text-gray-600">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        PDF ditampilkan langsung di browser. Gunakan zoom browser untuk memperbesar/memperkecil
                    </span>
                </div>
            </div>

            <!-- PDF Viewer with multiple fallbacks -->
            <div class="bg-gray-100 rounded-lg overflow-hidden shadow-inner">
                <div id="pdf-container" class="relative">
                    <!-- Primary: Native PDF embed -->
                    <embed id="pdf-embed" src="{{ $pdfPath }}" type="application/pdf" width="100%" height="700px"
                        class="rounded-lg" title="PDF Viewer - {{ $surat->jenisSurat->nama_jenis }}">

                    <!-- Secondary fallback: Object tag -->
                    <object id="pdf-object" data="{{ $pdfPath }}" type="application/pdf" width="100%"
                        height="700px" class="hidden rounded-lg">
                        <p>Browser Anda tidak mendukung tampilan PDF.</p>
                    </object>

                    <!-- Tertiary fallback: iframe -->
                    <iframe id="pdf-iframe" src="{{ $pdfPath }}" width="100%" height="700px"
                        class="hidden rounded-lg border-0" title="PDF Viewer">
                    </iframe>

                    <!-- Final fallback for browsers that don't support PDF viewing -->
                    <div id="pdf-fallback" class="hidden p-8 text-center bg-gray-50 rounded-lg">
                        <div class="flex flex-col items-center space-y-4">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">PDF Tidak Dapat Ditampilkan</h3>
                                <p class="text-gray-600 mb-4">Browser Anda tidak mendukung tampilan PDF secara langsung.
                                </p>
                                <a href="{{ $pdfPath }}" target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    Buka PDF di Tab Baru
                                </a>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Download Button -->
            <div class="mt-4 text-center">
                <a href="{{ $pdfPath }}" target="_blank"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Unduh PDF
                </a>
            </div>
        </div>

        <!-- Footer Information -->
        <div class="mt-8 pt-6 border-t text-center text-sm text-gray-500">
            <p>Sistem Verifikasi Surat Resmi - Desa Jeruksawit, Kecamatan Gondangrejo, Kabupaten Karanganyar</p>
            <p class="mt-1">Untuk informasi lebih lanjut, silakan hubungi kantor desa atau kunjungi website resmi</p>
        </div>
    </div>

    <!-- PDF Fallback Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const embed = document.getElementById('pdf-embed');
            const object = document.getElementById('pdf-object');
            const iframe = document.getElementById('pdf-iframe');
            const fallback = document.getElementById('pdf-fallback');

            let currentMethod = 'embed';
            let attempts = 0;
            const maxAttempts = 3;

            function tryNextMethod() {
                attempts++;

                if (attempts >= maxAttempts) {
                    // Show final fallback
                    hideAll();
                    fallback.classList.remove('hidden');
                    return;
                }

                hideAll();

                switch (currentMethod) {
                    case 'embed':
                        console.log('Trying PDF embed method...');
                        embed.classList.remove('hidden');
                        setTimeout(checkEmbed, 2000);
                        break;
                    case 'object':
                        console.log('Trying PDF object method...');
                        object.classList.remove('hidden');
                        setTimeout(checkObject, 2000);
                        break;
                    case 'iframe':
                        console.log('Trying PDF iframe method...');
                        iframe.classList.remove('hidden');
                        setTimeout(checkIframe, 2000);
                        break;
                    default:
                        fallback.classList.remove('hidden');
                }
            }

            function hideAll() {
                embed.style.display = 'none';
                object.style.display = 'none';
                iframe.style.display = 'none';
                fallback.classList.add('hidden');
            }

            function checkEmbed() {
                try {
                    if (embed.clientHeight === 0 || embed.clientWidth === 0) {
                        currentMethod = 'object';
                        tryNextMethod();
                    }
                } catch (e) {
                    currentMethod = 'object';
                    tryNextMethod();
                }
            }

            function checkObject() {
                try {
                    if (object.clientHeight === 0 || object.clientWidth === 0) {
                        currentMethod = 'iframe';
                        tryNextMethod();
                    }
                } catch (e) {
                    currentMethod = 'iframe';
                    tryNextMethod();
                }
            }

            function checkIframe() {
                try {
                    if (iframe.clientHeight === 0 || iframe.clientWidth === 0) {
                        currentMethod = 'fallback';
                        tryNextMethod();
                    }
                } catch (e) {
                    currentMethod = 'fallback';
                    tryNextMethod();
                }
            }

            // Handle errors
            embed.addEventListener('error', function() {
                console.log('Embed failed, trying object...');
                currentMethod = 'object';
                tryNextMethod();
            });

            object.addEventListener('error', function() {
                console.log('Object failed, trying iframe...');
                currentMethod = 'iframe';
                tryNextMethod();
            });

            iframe.addEventListener('error', function() {
                console.log('Iframe failed, showing fallback...');
                currentMethod = 'fallback';
                tryNextMethod();
            });

            // Start with embed method
            setTimeout(checkEmbed, 2000);
        });
    </script>

    <style>
        /* Ensure PDF elements take full space */
        #pdf-container embed,
        #pdf-container object,
        #pdf-container iframe {
            border: none;
            border-radius: 0.5rem;
        }

        /* Loading animation for PDF */
        #pdf-container::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #6b7280;
            font-size: 1.1rem;
            z-index: 1;
        }

        #pdf-container.loaded::before {
            display: none;
        }
    </style>
</x-layouts.visitor-layout>
