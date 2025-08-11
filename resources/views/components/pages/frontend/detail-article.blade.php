<x-layouts.visitor-layout>
    <x-slot:title>Artikel Selengkapnya | </x-slot:title>

    @push('style')
        <style>
            /* Container utama gallery */
            .grid.gap-4 {
                max-width: 1000px;
                margin: 0 auto;
            }

            /* Gambar besar utama tanpa crop */
            #expandedImg {
                width: 100%;
                height: auto;
                border-radius: 0.5rem;
                object-fit: contain;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                background: #f8f8f8;
            }

            /* Container thumbnails full size, tidak scrollable, bisa wrap */
            .thumbnail-container {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
                margin-top: 0.75rem;
                justify-content: center;
            }

            /* Thumbnail gambar tanpa crop, ukuran proporsional, full size di grid */
            .imgClick {
                height: 120px;
                width: auto;
                border-radius: 0.5rem;
                cursor: pointer;
                border: 3px solid transparent;
                object-fit: contain;
                transition: all 0.3s ease;
                opacity: 0.8;
                background: #f8f8f8;
                flex-shrink: 0;
            }

            .imgClick.active {
                border-color: #22c55e;
                opacity: 1;
                transform: scale(1.05);
                box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
            }

            .imgClick:hover {
                border-color: #22c55e;
                opacity: 1;
                transform: scale(1.03);
            }

            /* Responsive */
            @media (max-width: 768px) {
                #expandedImg {
                    max-height: 300px;
                }

                .imgClick {
                    height: 90px;
                }
            }
        </style>
    @endpush

    <section class="pt-20 font-inter">
        <div class="max-w-screen-xl px-4 mx-auto">

            <div class="grid gap-4">
                <div>
                    <img id="expandedImg" src="{{ Storage::url($article->gambar_articles[0]->image_url) }}"
                        alt="Gambar Utama Artikel">
                </div>
                <div class="thumbnail-container">
                    @foreach ($article->gambar_articles as $gallery)
                        <img class="imgClick" src="{{ Storage::url($gallery->image_url) }}" alt="Thumbnail Gambar">
                    @endforeach
                </div>
            </div>

            <div
                class="relative z-20 h-auto max-w-screen-md px-10 mx-auto bg-white rounded-md xl:max-w-screen-lg md:py-10 mt-8 lg:drop-shadow-xl">
                <h1 class="text-4xl font-bold leading-normal md:text-4xl text-pretty">{{ $article->title }}</h1>
                <div class="flex flex-col gap-1 my-4">
                    <div class="flex flex-col md:flex-row md:gap-4">
                        <p class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-new" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Dibuat Oleh <span class="font-semibold text-green-new">{{ $article->user->name }}</span>
                        </p>
                        <p class="inline-flex items-center gap-2 text-sm bg-gray-50 px-3 py-1 rounded-full">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                            <span class="font-medium">{{ number_format($article->views) }}</span>
                            <span class="text-gray-500">kali dilihat</span>
                        </p>
                    </div>
                    <p class="flex items-center gap-2 text-gray-600">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        {{ \Carbon\Carbon::parse($article->created_at)->locale('id')->translatedFormat('l, j F Y') }}
                    </p>
                </div>
                <div class="reset">
                    {!! $article->content !!}
                </div>

            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const expandedImg = document.getElementById('expandedImg');
            const thumbnails = document.querySelectorAll('.imgClick');

            thumbnails.forEach(img => {
                img.addEventListener('click', function() {
                    expandedImg.src = this.src;

                    // Hapus class active dari semua thumbnail
                    thumbnails.forEach(i => i.classList.remove('active'));

                    // Tambah class active pada yang diklik
                    this.classList.add('active');
                });
            });

            // Set aktif thumbnail pertama saat load halaman
            if (thumbnails.length > 0) {
                thumbnails[0].classList.add('active');
            }
        });
    </script>

</x-layouts.visitor-layout>
