<aside :class="sidebarToggle ? 'translate-x-0' : '-translate-x-full'"
    class="absolute font-inter left-0 top-0 z-9999 flex h-screen w-72.5 flex-col overflow-y-hidden bg-[#A2AF9B] duration-300 ease-linear dark:bg-boxdark lg:static lg:translate-x-0"
    @click.outside="sidebarToggle = false">
    <!-- SIDEBAR HEADER -->
    <div class="flex items-center justify-between lg:justify-center gap-2 px-6 py-5.5 lg:py-6.5">
        <a href="#">
            <img class="w-20" src="{{ asset('assets/img/Karanganyar.png') }}" alt="Logo" />
        </a>

        <button class="block lg:hidden" @click.stop="sidebarToggle = !sidebarToggle">
            <svg class="fill-current" width="20" height="18" viewBox="0 0 20 18" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M19 8.175H2.98748L9.36248 1.6875C9.69998 1.35 9.69998 0.825 9.36248 0.4875C9.02498 0.15 8.49998 0.15 8.16248 0.4875L0.399976 8.3625C0.0624756 8.7 0.0624756 9.225 0.399976 9.5625L8.16248 17.4375C8.31248 17.5875 8.53748 17.7 8.76248 17.7C8.98748 17.7 9.17498 17.625 9.36248 17.475C9.69998 17.1375 9.69998 16.6125 9.36248 16.275L3.02498 9.8625H19C19.45 9.8625 19.825 9.4875 19.825 9.0375C19.825 8.55 19.45 8.175 19 8.175Z"
                    fill="" />
            </svg>
        </button>
    </div>
    <!-- SIDEBAR HEADER -->

    <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
        <!-- Sidebar Menu -->
        <nav class="px-4 py-4 lg:mt-4 lg:px-6" x-data="{ selected: $persist('Dashboard') }">
            @auth
                <div>
                    <ul class="mb-6 flex flex-col gap-1.5">
                        <!-- Menu Item Dashboard -->
                        <li>
                            <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark-dashboard dark:hover:bg-meta-4 {{ in_array(Route::current()->getName(), [auth()->user()->role . '.dashboard']) ? 'bg-graydark-dashboard dark:bg-meta-4' : '' }}"
                                href="{{ route(auth()->user()->role . '.dashboard') }}">
                                <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.10322 0.956299H2.53135C1.5751 0.956299 0.787598 1.7438 0.787598 2.70005V6.27192C0.787598 7.22817 1.5751 8.01567 2.53135 8.01567H6.10322C7.05947 8.01567 7.84697 7.22817 7.84697 6.27192V2.72817C7.8751 1.7438 7.0876 0.956299 6.10322 0.956299ZM6.60947 6.30005C6.60947 6.5813 6.38447 6.8063 6.10322 6.8063H2.53135C2.2501 6.8063 2.0251 6.5813 2.0251 6.30005V2.72817C2.0251 2.44692 2.2501 2.22192 2.53135 2.22192H6.10322C6.38447 2.22192 6.60947 2.44692 6.60947 2.72817V6.30005Z"
                                        fill="" />
                                    <path
                                        d="M15.4689 0.956299H11.8971C10.9408 0.956299 10.1533 1.7438 10.1533 2.70005V6.27192C10.1533 7.22817 10.9408 8.01567 11.8971 8.01567H15.4689C16.4252 8.01567 17.2127 7.22817 17.2127 6.27192V2.72817C17.2127 1.7438 16.4252 0.956299 15.4689 0.956299ZM15.9752 6.30005C15.9752 6.5813 15.7502 6.8063 15.4689 6.8063H11.8971C11.6158 6.8063 11.3908 6.5813 11.3908 6.30005V2.72817C11.3908 2.44692 11.6158 2.22192 11.8971 2.22192H15.4689C15.7502 2.22192 15.9752 2.44692 15.9752 2.72817V6.30005Z"
                                        fill="" />
                                    <path
                                        d="M6.10322 9.92822H2.53135C1.5751 9.92822 0.787598 10.7157 0.787598 11.672V15.2438C0.787598 16.2001 1.5751 16.9876 2.53135 16.9876H6.10322C7.05947 16.9876 7.84697 16.2001 7.84697 15.2438V11.7001C7.8751 10.7157 7.0876 9.92822 6.10322 9.92822ZM6.60947 15.272C6.60947 15.5532 6.38447 15.7782 6.10322 15.7782H2.53135C2.2501 15.7782 2.0251 15.5532 2.0251 15.272V11.7001C2.0251 11.4188 2.2501 11.1938 2.53135 11.1938H6.10322C6.38447 11.1938 6.60947 11.4188 6.60947 11.7001V15.272Z"
                                        fill="" />
                                    <path
                                        d="M15.4689 9.92822H11.8971C10.9408 9.92822 10.1533 10.7157 10.1533 11.672V15.2438C10.1533 16.2001 10.9408 16.9876 11.8971 16.9876H15.4689C16.4252 16.9876 17.2127 16.2001 17.2127 15.2438V11.7001C17.2127 10.7157 16.4252 9.92822 15.4689 9.92822ZM15.9752 15.272C15.9752 15.5532 15.7502 15.7782 15.4689 15.7782H11.8971C11.6158 15.7782 11.3908 15.5532 11.3908 15.272V11.7001C11.3908 11.4188 11.6158 11.1938 11.8971 11.1938H15.4689C15.7502 11.1938 15.9752 11.4188 15.9752 11.7001V15.272Z"
                                        fill="" />
                                </svg>

                                Dashboard
                            </a>
                        </li>
                        <!-- Menu Item Dashboard -->

                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'super_admin')
                            <li>
                                @php
                                    $roleName = auth()->user()->role;
                                    $routeName = $roleName . '.users.index';
                                @endphp

                                <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark-dashboard dark:hover:bg-meta-4 {{ in_array(Route::current()->getName(), [$roleName . '.users.index', $roleName . '.users.create', $roleName . '.users.edit']) ? 'bg-graydark-dashboard dark:bg-meta-4' : '' }}"
                                    href="{{ route($routeName) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" style="fill: rgba(251, 251, 251, 1);transform: ;msFilter:;">
                                        <path
                                            d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z">
                                        </path>
                                    </svg> Pengguna
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->role != 'writer')
                            <li>
                                @php
                                    $roleName = auth()->user()->role;
                                    $routeName = $roleName . '.destinations.index';
                                @endphp

                                <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark-dashboard dark:hover:bg-meta-4 {{ in_array(Route::current()->getName(), [$roleName . '.destinations.index', $roleName . '.destinations.create', $roleName . '.destinations.edit']) ? 'bg-graydark-dashboard dark:bg-meta-4' : '' }}"
                                    href="{{ route($routeName) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" style="fill: rgba(251, 251, 251, 1);transform: ;msFilter:;">
                                        <path
                                            d="M20 6h-3V4c0-1.103-.897-2-2-2H9c-1.103 0-2 .897-2 2v2H4c-1.103 0-2 .897-2 2v11c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V8c0-1.103-.897-2-2-2zm-4 2v11H8V8h8zm-1-4v2H9V4h6zM4 8h2v11H4V8zm14 11V8h2l.001 11H18z">
                                        </path>
                                    </svg> Wisata
                                </a>
                            </li>

                            {{-- UMKM Menu --}}
                            <li>
                                @php
                                    $roleName = auth()->user()->role;
                                    $umkmRouteName = $roleName . '.umkm.index';
                                @endphp

                                <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark-dashboard dark:hover:bg-meta-4 {{ in_array(Route::current()->getName(), [$roleName . '.umkm.index', $roleName . '.umkm.create', $roleName . '.umkm.edit']) ? 'bg-graydark-dashboard dark:bg-meta-4' : '' }}"
                                    href="{{ route($umkmRouteName) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" style="fill: rgba(251, 251, 251, 1);transform: ;msFilter:;">
                                        <path
                                            d="M21 7H3c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2zm0 10H3V9h18v8z" />
                                        <path d="M5 11h2v2H5zm0 4h2v2H5zm4-4h2v2H9zm0 4h2v2H9zm4-4h2v2h-2zm0 4h2v2h-2z" />
                                    </svg> UMKM
                                </a>
                            </li>
                        @endif

                        {{-- Perangkat Desa Menu --}}
                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'super_admin')
                            <li>
                                @php
                                    $roleName = auth()->user()->role;
                                    $perangkatDesaRouteName = $roleName . '.perangkat-desa.index';
                                @endphp

                                <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark-dashboard dark:hover:bg-meta-4 {{ in_array(Route::current()->getName(), [$roleName . '.perangkat-desa.index', $roleName . '.perangkat-desa.create', $roleName . '.perangkat-desa.edit']) ? 'bg-graydark-dashboard dark:bg-meta-4' : '' }}"
                                    href="{{ route($perangkatDesaRouteName) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" style="fill: rgba(251, 251, 251, 1);transform: ;msFilter:;">
                                        <path
                                            d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zM8.5 9a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 8.5 9zm7 0a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 15.5 9zm-3.5 9c-3 0-4-2-4-2h8s-1 2-4 2z">
                                        </path>
                                    </svg> Perangkat Desa
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->role != 'owner')
                            <li>
                                @php
                                    $roleName = auth()->user()->role;
                                    $routeName = $roleName . '.articles.index';
                                @endphp

                                <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark-dashboard dark:hover:bg-meta-4 {{ in_array(Route::current()->getName(), [$roleName . '.articles.index', $roleName . '.articles.create', $roleName . '.articles.edit']) ? 'bg-graydark-dashboard dark:bg-meta-4' : '' }}"
                                    href="{{ route($routeName) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" style="fill: rgb(255, 255, 255);transform: ;msFilter:;">
                                        <path d="m16 2.012 3 3L16.713 7.3l-3-3zM4 14v3h3l8.299-8.287-3-3zm0 6h16v2H4z">
                                        </path>
                                    </svg> Artikel
                                </a>
                            </li>
                        @endif

                        <li>
                            <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark-dashboard dark:hover:bg-meta-4 {{ Route::current()->getName() == auth()->user()->role . '.layanan-surat' ? 'bg-graydark-dashboard dark:bg-meta-4' : '' }}"
                                href="{{ route(auth()->user()->role . '.layanan-surat') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    style="fill: rgb(255, 255, 255);transform: ;msFilter:;">
                                    <path
                                        d="M19.937 8.68c-.011-.032-.02-.063-.033-.094a.997.997 0 0 0-.196-.293l-6-6a.997.997 0 0 0-.293-.196c-.03-.014-.062-.022-.094-.033a.991.991 0 0 0-.259-.051C13.04 2.011 13.021 2 13 2H6c-1.103 0-2 .897-2 2v16c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2V9c0-.021-.011-.04-.013-.062a.99.99 0 0 0-.05-.258zM16.586 8H14V5.414L16.586 8zM6 20V4h6v5a1 1 0 0 0 1 1h5l.002 10H6z">
                                    </path>
                                    <path d="M8 12h8v2H8zm0 4h8v2H8zm0-8h2v2H8z"></path>
                                </svg> Layanan Surat Menyurat
                            </a>
                        </li>

                        {{-- Website Settings Menu - Admin, Super Admin, Owner --}}
                        @if (auth()->user()->role == 'owner' || auth()->user()->role == 'admin' || auth()->user()->role == 'super_admin')
                            <li>
                                @php
                                    $roleName = auth()->user()->role;
                                    if ($roleName == 'super_admin') {
                                        $websiteSettingsRouteName = 'super_admin.website-settings.index';
                                        $routeCheck = 'super_admin.website-settings.index';
                                    } else {
                                        $websiteSettingsRouteName = $roleName . '.website-settings.index';
                                        $routeCheck = $roleName . '.website-settings.index';
                                    }
                                @endphp
                                <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark-dashboard dark:hover:bg-meta-4 {{ Route::current()->getName() == $routeCheck ? 'bg-graydark-dashboard dark:bg-meta-4' : '' }}"
                                    href="{{ route($websiteSettingsRouteName) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" style="fill: rgb(255, 255, 255);transform: ;msFilter:;">
                                        <path
                                            d="m2.344 15.271 2 3.46a1 1 0 0 0 1.366.365l1.396-.806c.58.457 1.221.832 1.895 1.112V21a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-1.598a8.094 8.094 0 0 0 1.895-1.112l1.396.806c.477.275 1.091.11 1.366-.365l2-3.46a1.004 1.004 0 0 0-.365-1.366l-1.372-.793a7.683 7.683 0 0 0-.002-2.224l1.372-.793c.476-.275.641-.89.365-1.366l-2-3.46a1 1 0 0 0-1.366-.365l-1.396.806A8.034 8.034 0 0 0 15 4.598V3a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v1.598A8.094 8.094 0 0 0 7.105 5.71L5.71 4.904a.999.999 0 0 0-1.366.365l-2 3.46a1.004 1.004 0 0 0 .365 1.366l1.372.793a7.683 7.683 0 0 0 0 2.224l-1.372.793c-.476.275-.641.89-.365 1.366zM12 8c2.206 0 4 1.794 4 4s-1.794 4-4 4-4-1.794-4-4 1.794-4 4-4z">
                                        </path>
                                    </svg> Website Settings
                                </a>
                            </li>
                        @endif

                        <!-- Back to Frontend Button -->
                        <li class="mt-6 pt-4 border-t border-graydark-dashboard">
                            <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out bg-green-700 hover:bg-green-800"
                                href="{{ route('index') }}" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    style="fill: rgb(255, 255, 255);transform: ;msFilter:;">
                                    <path d="M12 2.1L1 12h3v9h6v-6h4v6h6v-9h3L12 2.1z"></path>
                                </svg> Kembali ke Website
                            </a>
                        </li>
                    </ul>
                </div>
            @else
                <div class="text-center text-gray-500 py-8">
                    <p>Please log in to access the dashboard.</p>
                </div>
            @endauth

        </nav>
        <!-- Sidebar Menu -->
    </div>
</aside>
