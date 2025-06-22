<x-guest-layout>
    {{-- Menggunakan style yang sama dengan halaman register untuk konsistensi --}}
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
            <h2 class="text-xl font-bold text-gray-800 mt-4">Portal Login</h2>
            <p class="text-sm text-gray-500">Silakan masuk menggunakan email dan password Anda.</p>
        </div>

        <div class="text-center mb-6">
            <div class="tab-nav">
                <a href="{{ route('login') }}" class="tab-link active">Login</a>
                <a href="{{ route('register') }}" class="tab-link">Daftar Akun</a>
            </div>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        {{-- BAGIAN BARU UNTUK MENAMPILKAN SEMUA ERROR --}}
        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-700 border border-red-200">
                <h3 class="font-bold">Oops! Terjadi kesalahan.</h3>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        {{-- Mengubah pesan error standar ke Bahasa Indonesia --}}
                        @if ($error === 'These credentials do not match our records.')
                            <li>Email atau password yang Anda masukkan salah.</li>
                        @else
                            <li>{{ $error }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="text-sm font-medium text-gray-700">Alamat Email</label>
                <div class="mt-1 relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" /><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" /></svg>
                    </span>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus placeholder="email@anda.com"
                           class="w-full py-3 pr-3 rounded-lg input-portal">
                </div>
                {{-- Komponen ini tetap ada untuk menampilkan error di bawah field jika perlu --}}
                {{-- <x-input-error :messages="$errors->get('email')" class="mt-2" /> --}}
            </div>

            <div>
                <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                <div class="mt-1 relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" /></svg>
                    </span>
                    <input id="password" name="password" type="password" required placeholder="Masukkan password Anda"
                           class="w-full py-3 pr-3 rounded-lg input-portal" autocomplete="current-password">
                </div>
                {{-- <x-input-error :messages="$errors->get('password')" class="mt-2" /> --}}
            </div>

            <div class="flex items-center justify-between">
                <label for="remember_me" class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 block text-sm text-gray-700">Ingat Saya</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-blue-600 hover:underline">Lupa Password?</a>
                @endif
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-3 rounded-lg btn-portal">
                    Login
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
