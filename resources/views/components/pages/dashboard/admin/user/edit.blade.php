<x-layouts.dashboard>

    {{-- Breadcrumb --}}
    <nav class="mb-5">
        <ol class="flex items-center gap-2">
            <li>
                <a class="font-medium" href="{{ route(auth()->user()->role . '.dashboard') }}">Dashboard /</a>
            </li>
            <li>
                <a class="font-medium" href="{{ route(auth()->user()->role . '.users.index') }}">Pengguna
                    /</a>
            </li>
            <li class="font-medium text-primary">Ubah</li>
        </ol>
    </nav>

    <form action="{{ route(auth()->user()->role . '.users.update', $user->id) }}" method="POST"
        @if (auth()->user()->role == 'super_admin') x-data="{ showPassword: false, showConfirmPassword: false }" @endif>
        @csrf
        @method('PUT')

        <div class="form-1">
            <div class="">
                <h1 class="mb-6 text-xl font-bold text-black-dashboard dark:text-white-dahsboard"> Ubah Pengguna
                </h1>
            </div>

            <div class="px-6 py-6 mb-6 bg-white rounded-lg shadow-lg dark:bg-black">
                <div class="mb-4.5">
                    <label for="role"
                        class="mb-3 block text-sm font-medium text-black-dashboard dark:text-white-dahsboard">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent dark:bg-form-input">
                        <select name="role"
                            class="relative z-20 w-full appearance-none capitalize rounded border border-stroke bg-transparent px-5 py-3 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                            :class="isOptionSelected && 'text-black dark:text-white'" @change="isOptionSelected = true">
                            <option disabled selected class="text-body capitalize">Pilih Role</option>
                            <option value="admin" class="text-body capitalize"
                                {{ $user->role == 'admin' ? 'selected' : '' }}>
                                Admin</option>
                            <option value="owner" class="text-body capitalize"
                                {{ $user->role == 'owner' ? 'selected' : '' }}>
                                Penanggung Jawab Wisata</option>
                            <option value="writer" class="text-body capitalize"
                                {{ $user->role == 'writer' ? 'selected' : '' }}>
                                Penulis Konten</option>
                        </select>
                        <x-partials.dashboard.input-error :messages="$errors->get('role')" />
                    </div>
                </div>

                <div class="mb-4.5">
                    <label for="name"
                        class="mb-3 block text-sm font-medium text-black-dashboard dark:text-white-dahsboard">
                        Nama <span class="text-red-500">*</span>
                    </label>
                    <input type="text" required name="name" autocomplete="name" maxlength="100"
                        placeholder="Masukan Nama" value="{{ $user->name }}"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black-dashboard outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white-dahsboard dark:focus:border-primary" />
                    <x-partials.dashboard.input-error :messages="$errors->get('name')" />
                </div>

                <div class="mb-4.5">
                    <label for="email"
                        class="mb-3 block text-sm font-medium text-black-dashboard dark:text-white-dahsboard">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" required name="email" autocomplete="email" placeholder="Masukan Email"
                        maxlength="100" value="{{ $user->email }}"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black-dashboard outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white-dahsboard dark:focus:border-primary" />
                    <x-partials.dashboard.input-error :messages="$errors->get('email')" />
                </div>

                @if (auth()->user()->role == 'super_admin')
                    <div class="mb-4.5">
                        <label for="password"
                            class="mb-3 block text-sm font-medium text-black-dashboard dark:text-white-dahsboard">
                            Ubah Password
                        </label>
                        <div class="relative">
                            <input type="password" name="password" placeholder="Masukan Password"
                                autocomplete="new-password" :type="showPassword ? 'text' : 'password'"
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black-dashboard outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white-dahsboard dark:focus:border-primary" />
                            <button type="button" @click="showPassword = !showPassword" tabindex="-1"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <template x-if="!showPassword">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </template>
                                <template x-if="showPassword">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a10.05 10.05 0 012.155-3.434m1.45-1.2A9.97 9.97 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.051 10.051 0 01-4.29 5.344M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                                    </svg>
                                </template>
                            </button>
                        </div>
                        <x-partials.dashboard.input-error :messages="$errors->get('password')" />
                    </div>

                    <div class="mb-4.5">
                        <label for="password_confirmation"
                            class="mb-3 block text-sm font-medium text-black-dashboard dark:text-white-dahsboard">
                            Password Confirmation
                        </label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" autocomplete="new-password"
                                placeholder="Konfirmasi Password" :type="showConfirmPassword ? 'text' : 'password'"
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black-dashboard outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white-dahsboard dark:focus:border-primary" />
                            <button type="button" @click="showConfirmPassword = !showConfirmPassword" tabindex="-1"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <template x-if="!showConfirmPassword">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </template>
                                <template x-if="showConfirmPassword">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a10.05 10.05 0 012.155-3.434m1.45-1.2A9.97 9.97 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.051 10.051 0 01-4.29 5.344M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                                    </svg>
                                </template>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <button type="submit"
            class="flex justify-center w-full p-3 font-medium text-white rounded bg-deep-koamaru-600 hover:bg-opacity-90">
            Ubah
        </button>
    </form>

</x-layouts.dashboard>
