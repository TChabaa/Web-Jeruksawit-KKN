<x-layouts.auth>
    <x-slot:title>Login | </x-slot:title>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-28 w-auto" src="{{ asset('assets/img/logo.png') }}" alt="Desa Sukarame">
            <h2 class="mt-10 text-center text-3xl font-bold leading-9 tracking-tight text-gray-900">Masuk</h2>
        </div>

        <div class="mt-2 sm:mx-auto sm:w-full" x-data="{ show: false }">
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="">
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" autocomplete="username" required
                                autofocus
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-new sm:text-sm sm:leading-6">
                        </div>
                        <x-partials.dashboard.input-error :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <div class="flex items-center justify-between mt-2">
                            <label for="password"
                                class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                        </div>
                        <div class="relative mt-2">
                            <input :type="show ? 'text' : 'password'" id="password" name="password"
                                autocomplete="current-password" required
                                class="block w-full rounded-md border-0 py-1.5 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-new sm:text-sm sm:leading-6">

                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" tabindex="-1">
                                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                    viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M13.875 12.825a3 3 0 0 1-4.7-4.7" />
                                    <path d="M10 3C5 3 1 10 1 10s1.5 3.8 5 6.4M19 10s-1.5-3.8-5-6.4" />
                                    <path d="M4.222 4.222 15.778 15.778" />
                                </svg>
                                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                    viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M1 10s4-7 9-7 9 7 9 7-4 7-9 7-9-7-9-7z" />
                                    <circle cx="10" cy="10" r="3" />
                                </svg>

                            </button>
                        </div>
                        <x-partials.dashboard.input-error :messages="$errors->get('password')" />
                    </div>
                </div>

                <div class="flex items-center">
                    <input class="border" type="checkbox" name="remember" id="remember_me">
                    <label class="ml-2 block text-sm text-gray-900" for="remember_me">ingat saya</label>
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-green-new px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-new transition-all duration-500">Masuk</button>
                </div>
            </form>

            <div class="mt-4">
                <a href="/"
                    class="flex w-full justify-center rounded-md  border-2 border-green-new px-3 py-1.5 text-sm font-semibold leading-6 text-green-new shadow-sm ">Kembali</a>
            </div>
        </div>
    </div>
</x-layouts.auth>
