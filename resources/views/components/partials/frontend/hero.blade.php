<section class="pt-10 bg-gradient-to-b from-[#e6f1de] to-white">
    <div
        class="max-w-screen-xl px-4 pt-20 pb-16 mx-auto lg:gap-12 xl:gap-0 lg:py-16 lg:grid lg:grid-cols-12 lg:pt-28 font-inter">

        {{-- Hero Text & Video --}}
        <div class="mr-auto place-self-center lg:col-span-7 space-y-8">
            <h1 id="slogan"
                class="min-h-[190px] max-w-2xl text-4xl font-extrabold leading-none tracking-tight md:text-5xl xl:text-6xl">
            </h1>

            <p class="max-w-2xl font-light text-gray-700 md:text-lg lg:text-xl">
            <p class="text-lg md:text-xl text-gray-700 leading-relaxed">
                Website ini dirancang untuk memudahkan Anda mendapatkan <span class="font-bold text-green-new">informasi
                    terkini</span>
                seputar Desa Jeruksawit. Temukan berita desa, profil UMKM, destinasi wisata, dan gunakan layanan
                <span class="font-bold text-green-new">surat-menyurat online</span> tanpa perlu datang ke kantor
                desa.
                Semuanya hadir untuk pelayanan publik yang lebih <span class="italic">cepat, transparan, dan mudah
                    diakses</span>.
            </p>

        </div>

        {{-- Hero Video --}}
        <div class="hidden lg:flex lg:col-span-5 lg:items-center lg:justify-center lg:rounded-lg lg:overflow-hidden">
            <iframe loading="lazy"
                title="{{ \App\Models\WebsiteSetting::getValue('hero_youtube_title', 'DESA JERUKSAWIT KAB. KARANGANYAR') }}"
                class="w-full h-full rounded-lg"
                src="{{ \App\Models\WebsiteSetting::getValue('hero_youtube_url', 'https://www.youtube.com/embed/i4alQJYhKtw?si=jqo-1bsz6RHNOyDP') }}"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        </div>
    </div>

    {{-- Fitur Unggulan Full Width --}}
    <div class="max-w-6xl mx-auto px-4 md:px-0">
        <div class="grid md:grid-cols-3 gap-8 mt-8 text-left"> <!-- mt-12 jadi mt-8 -->
            <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition duration-300">
                <div class="text-green-new text-3xl mb-3">📢</div>
                <h3 class="font-semibold text-lg text-gray-800 mb-2">Berita & Informasi</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Update berita desa, agenda kegiatan, dan pengumuman resmi langsung dari perangkat desa.
                </p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition duration-300">
                <div class="text-green-new text-3xl mb-3">📄</div>
                <h3 class="font-semibold text-lg text-gray-800 mb-2">Layanan Surat Online</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Ajukan berbagai surat resmi secara online, cepat dan tanpa ribet, langsung dari rumah Anda.
                </p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition duration-300">
                <div class="text-green-new text-3xl mb-3">🌾</div>
                <h3 class="font-semibold text-lg text-gray-800 mb-2">Wisata & UMKM</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Jelajahi potensi desa mulai dari objek wisata, kuliner, hingga produk UMKM lokal unggulan.
                </p>
            </div>
        </div>
    </div>

</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        gsap.registerPlugin(TextPlugin);
        const myElement = document.getElementById('slogan');
        const sloganText = "Selamat Datang di Website Resmi Desa Jeruksawit";
        const animDuration = 3; // durasi animasi teks muncul (detik)
        const stayDuration = 30; // durasi teks stay sebelum menghilang (detik)
        const fadeDuration = 1; // durasi fade out (detik)

        function animateSlogan() {
            // Animasi teks muncul
            gsap.to(myElement, {
                text: sloganText,
                duration: animDuration,
                ease: "none",
                onComplete: () => {
                    // Setelah muncul, tunggu stayDuration detik
                    setTimeout(() => {
                        // Fade out teks
                        gsap.to(myElement, {
                            duration: fadeDuration,
                            opacity: 0,
                            onComplete: () => {
                                // Reset teks dan opacity
                                myElement.textContent = "";
                                gsap.set(myElement, {
                                    opacity: 1
                                });
                                // Mulai animasi ulang
                                animateSlogan();
                            }
                        });
                    }, stayDuration * 1000);
                }
            });
        }

        animateSlogan();
    });
</script>
