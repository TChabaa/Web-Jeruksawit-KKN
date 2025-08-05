<x-Layouts.visitor-layout>
    <x-slot:title>Tentang Kami | </x-slot:title>
    <header>
        <x-partials.frontend.header />
    </header>

    <section class="mx-auto  max-w-7xl">

        <x-partials.frontend.description />
    </section>

    <!-- Perangkat Desa Section -->
    <section class="bg-white py-16 font-inter">
        <div class="max-w-7xl mx-auto px-4">
            <div class="mb-12 text-center">
                <h2 class="text-4xl font-extrabold text-gray-900 mb-4">Perangkat Desa Jeruksawit</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Tim perangkat desa yang berkomitmen tinggi untuk melayani dan memajukan Desa Jeruksawit dengan
                    dedikasi penuh
                </p>
            </div>

            @if ($perangkatDesas->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($perangkatDesas as $perangkatDesa)
                        <x-partials.frontend.card-perangkat-desa :$perangkatDesa />
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="max-w-md mx-auto">
                        <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Data</h3>
                        <p class="text-gray-500">Data perangkat desa belum tersedia saat ini</p>
                    </div>
                </div>
            @endif
        </div>
    </section>



</x-Layouts.visitor-layout>
