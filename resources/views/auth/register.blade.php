<x-guest-layout>
    {{-- Asumsikan Anda memiliki styling untuk .tab-nav, .tab-link, .active, .input-portal, .btn-portal di file CSS Anda. --}}
    {{-- Jika tidak, Anda bisa menggantinya dengan kelas-kelas standar Tailwind CSS. --}}
    <style>
        .tab-nav {
            display: inline-flex;
            background-color: #e5e7eb; /* bg-gray-200 */
            border-radius: 9999px; /* rounded-full */
            padding: 0.25rem; /* p-1 */
        }
        .tab-link {
            padding: 0.5rem 1.5rem; /* px-6 py-2 */
            border-radius: 9999px; /* rounded-full */
            font-weight: 500; /* font-medium */
            color: #4b5563; /* text-gray-600 */
            transition: color 0.3s, background-color 0.3s;
        }
        .tab-link.active {
            background-color: #ffffff; /* bg-white */
            color: #3b82f6; /* text-blue-600 */
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1); /* shadow */
        }
        .input-portal {
            padding-left: 2.75rem; /* pl-11 */
            border: 1px solid #d1d5db; /* border-gray-300 */
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .input-portal:focus {
            border-color: #60a5fa; /* focus:border-blue-400 */
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.5); /* focus:ring */
        }
        .btn-portal {
            background-color: #3b82f6; /* bg-blue-600 */
            color: white;
            font-weight: 600; /* font-semibold */
            transition: background-color 0.3s;
        }
        .btn-portal:hover {
            background-color: #2563eb; /* hover:bg-blue-700 */
        }
    </style>

    <div class="w-full bg-white p-8 md:p-10 rounded-2xl shadow-lg">

        <div class="text-center mb-8">
            <a href="/" class="flex justify-center items-center text-slate-800">
                <svg class="h-8 w-auto text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                         <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/>
                </svg>
                <span class="ml-3 font-bold text-3xl">LaporCepat</span>
            </a>
            <h2 class="text-xl font-bold text-gray-800 mt-4">Buat Akun Baru</h2>
            <p class="text-sm text-gray-500">Isi data di bawah ini untuk memulai pelaporan.</p>
        </div>

        <div class="text-center mb-6">
            <div class="tab-nav">
                <a href="{{ route('login') }}" class="tab-link">Login</a>
                <a href="{{ route('register') }}" class="tab-link active">Daftar Akun</a>
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="text-sm font-medium text-gray-700">Nama Lengkap</label>
                <div class="mt-1 relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                    </span>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus placeholder="Nama sesuai KTP"
                           class="w-full py-3 pr-3 rounded-lg input-portal">
                </div>
                {{-- TAMBAHKAN INI UNTUK MENAMPILKAN ERROR NAMA --}}
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <label for="email" class="text-sm font-medium text-gray-700">Alamat Email</label>
                <div class="mt-1 relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" /><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" /></svg>
                    </span>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required placeholder="email@anda.com"
                           class="w-full py-3 pr-3 rounded-lg input-portal">
                </div>
                {{-- TAMBAHKAN INI UNTUK MENAMPILKAN ERROR EMAIL --}}
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <label for="phone_number" class="text-sm font-medium text-gray-700">Nomor Telepon</label>
                <div class="mt-1 relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" /></svg>
                    </span>
                    <input id="phone_number" name="phone_number" type="tel" value="{{ old('phone_number') }}" required placeholder="Contoh: 081234567890"
                           class="w-full py-3 pr-3 rounded-lg input-portal">
                </div>
                {{-- TAMBAHKAN INI UNTUK MENAMPILKAN ERROR NOMOR TELEPON --}}
                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
            </div>

            <div>
                <label for="nik" class="text-sm font-medium text-gray-700">NIK (Nomor Induk Kependudukan)</label>
                <div class="mt-1 relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" /></svg>
                    </span>
                    <input id="nik" name="nik" type="text" value="{{ old('nik') }}" required placeholder="16 digit nomor NIK"
                           class="w-full py-3 pr-3 rounded-lg input-portal">
                </div>
                {{-- TAMBAHKAN INI UNTUK MENAMPILKAN ERROR NIK --}}
                <x-input-error :messages="$errors->get('nik')" class="mt-2" />
            </div>

            <div>
                <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                <div class="mt-1 relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" /></svg>
                    </span>
                    <input id="password" name="password" type="password" required placeholder="Minimal 8 karakter"
                           class="w-full py-3 pr-3 rounded-lg input-portal" autocomplete="new-password">
                </div>
                {{-- TAMBAHKAN INI UNTUK MENAMPILKAN ERROR PASSWORD --}}
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <label for="password_confirmation" class="text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <div class="mt-1 relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" /></svg>
                    </span>
                    <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="Ulangi password Anda"
                           class="w-full py-3 pr-3 rounded-lg input-portal" autocomplete="new-password">
                </div>
                {{-- TAMBAHKAN INI UNTUK MENAMPILKAN ERROR KONFIRMASI PASSWORD --}}
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-3 rounded-lg btn-portal">
                    Daftar
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
