<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Pengguna: ') }} <span class="text-indigo-600 dark:text-indigo-400">{{ $user->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-6 border-b pb-3 dark:border-gray-700">
                        Formulir Edit Detail Pengguna
                    </h3>

                    @if ($errors->any())
                        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 dark:bg-red-700 dark:text-red-100 dark:border-red-600 rounded-md" role="alert">
                            <p class="font-bold">Harap perbaiki kesalahan berikut:</p>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            {{-- Informasi Akun Dasar --}}
                            <fieldset>
                                <legend class="text-base font-medium text-gray-900 dark:text-gray-100 mb-2">Informasi Akun</legend>
                                <div class="space-y-4">
                                    <div>
                                        <x-input-label for="name" :value="__('Nama Lengkap')" class="dark:text-gray-300" />
                                        <x-text-input id="name" class="block mt-1 w-full dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" type="text" name="name" :value="old('name', $user->name)" required autofocus />
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="email" :value="__('Alamat Email')" class="dark:text-gray-300" />
                                        <x-text-input id="email" class="block mt-1 w-full dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" type="email" name="email" :value="old('email', $user->email)" required />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="phone_number" :value="__('Nomor Telepon (Opsional)')" class="dark:text-gray-300" />
                                        <x-text-input id="phone_number" class="block mt-1 w-full dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" type="text" name="phone_number" :value="old('phone_number', $user->phone_number)" />
                                        <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="nik" :value="__('NIK (Opsional)')" class="dark:text-gray-300" />
                                        <x-text-input id="nik" class="block mt-1 w-full dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" type="text" name="nik" :value="old('nik', $user->nik)" />
                                        <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                                    </div>
                                </div>
                            </fieldset>

                            {{-- BAGIAN BARU: UBAH ROLE --}}
                            <fieldset class="border-t dark:border-gray-700 pt-6">
                                <legend class="text-base font-medium text-gray-900 dark:text-gray-100 mb-2">Hak Akses</legend>
                                <div>
                                    <x-input-label for="role" :value="__('Role Pengguna')" class="dark:text-gray-300" />
                                    <select id="role" name="role" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                        <option value="masyarakat" @if(old('role', $user->role) == 'masyarakat') selected @endif>Masyarakat</option>
                                        <option value="admin" @if(old('role', $user->role) == 'admin') selected @endif>Admin</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                </div>
                            </fieldset>


                            {{-- Opsi untuk mereset password pengguna oleh Admin --}}
                            <fieldset class="border-t dark:border-gray-700 pt-6">
                                <legend class="text-base font-medium text-gray-900 dark:text-gray-100 mb-2">Ubah Password (Opsional)</legend>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Kosongkan field password jika tidak ingin mengubah password pengguna ini.</p>
                                <div class="space-y-4">
                                    <div>
                                        <x-input-label for="password" :value="__('Password Baru')" class="dark:text-gray-300" />
                                        <x-text-input id="password" class="block mt-1 w-full dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" type="password" name="password" autocomplete="new-password" />
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" class="dark:text-gray-300" />
                                        <x-text-input id="password_confirmation" class="block mt-1 w-full dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" type="password" name="password_confirmation" autocomplete="new-password" />
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="mt-8 pt-6 border-t dark:border-gray-700 flex justify-end space-x-3">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Batal
                            </a>
                            <x-primary-button class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                                <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                Simpan Perubahan
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
