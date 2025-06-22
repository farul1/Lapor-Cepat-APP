<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LaporCepat') }} - Layanan Pengaduan Masyarakat</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">


        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }

            @keyframes gantiGambar {
                0%, 100% { background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('images/banjir.jpg') }}'); }
                20% { background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('images/fasilitaskesehatan.jpg') }}'); }
                40% { background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('images/jalanrusak.jpg') }}'); }
                60% { background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('images/jalanrusak2.jpg') }}'); }
                80% { background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('images/sampah.jpg') }}'); }
            }

            .hero-gradient {
                background-size: cover;
                background-position: center center;
                background-repeat: no-repeat;

                animation-name: gantiGambar;
                animation-duration: 25s;
                animation-iteration-count: infinite;
                animation-timing-function: ease-in-out;
            }

            .btn-primary {
                background-color: #2563EB;
                color: white;
            }
            .btn-primary:hover {
                background-color: #7e89b9;
            }
            .btn-secondary {
                background-color: transparent;
                color: white;
                border: 2px solid white;
            }
            .btn-secondary:hover {
                background-color: white;
                color: #333;
            }
            .feature-icon {
                background-color: rgba(0, 123, 255, 0.1);
                color: #007BFF;
            }
            .card-laporan {
                @apply bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-1;
            }
        </style>
    </head>
    <body class="antialiased bg-gray-100 text-gray-800">
        <div class="min-h-screen flex flex-col">
            <header class="bg-white shadow-md fixed w-full z-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-20">
                        <div class="flex-shrink-0">
                            <a href="{{ url('/') }}" class="flex items-center">
                                <svg class="h-10 w-auto text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/>
                                </svg>
                                <span class="ml-3 font-bold text-2xl text-gray-800">LaporCepat</span>
                            </a>
                        </div>

                        <nav class="hidden md:flex space-x-8 items-center">
                            <a href="#fitur" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-md font-medium">Fitur</a>
                            <a href="#cara-kerja" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-md font-medium">Cara Kerja</a>
                            <a href="{{ route('masyarakat.about') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-md font-medium">Tentang Kami</a>
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md text-md font-medium shadow-sm">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-md font-medium">Masuk</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="ml-4 text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-md text-md font-medium shadow-sm">Daftar</a>
                                    @endif
                                @endauth
                            @endif
                        </nav>
                         <div class="md:hidden flex items-center">
                            <button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                                <span class="sr-only">Open main menu</span>
                                <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                                </svg>
                                <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="md:hidden hidden" id="mobile-menu">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                        <a href="#fitur" class="text-gray-700 hover:bg-gray-50 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">Fitur</a>
                        <a href="#cara-kerja" class="text-gray-700 hover:bg-gray-50 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">Cara Kerja</a>
                        <a href="{{ route('masyarakat.about') }}" class="text-gray-700 hover:bg-gray-50 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">Tentang Kami</a>
                         @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-gray-700 bg-blue-100 hover:bg-blue-200 block px-3 py-2 rounded-md text-base font-medium">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 hover:bg-gray-50 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="text-gray-700 hover:bg-gray-50 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">Daftar</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </header>

            <main class="flex-grow pt-20">
                <section class="hero-gradient text-white py-20 md:py-32">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                        <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold tracking-tight">
                            Layanan Pengaduan Masyarakat <span class="block text-blue-300">LaporCepat</span>
                        </h1>
                        <p class="mt-6 text-lg sm:text-xl md:text-2xl max-w-3xl mx-auto">
                            Suarakan keluhan Anda, dapatkan tanggapan cepat dan transparan.
                        </p>
                        <div class="mt-10 flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                            <a href="{{ route('register') }}" class="btn-primary text-lg font-semibold px-8 py-4 rounded-lg shadow-lg transform transition hover:scale-105 duration-300 ease-in-out">
                                Buat Laporan Sekarang
                            </a>
                            <a href="#cara-kerja" class="btn-secondary text-lg font-semibold px-8 py-4 rounded-lg shadow-lg transform transition hover:scale-105 duration-300 ease-in-out">
                                Pelajari Lebih Lanjut
                            </a>
                        </div>
                    </div>
                </section>

                <section id="fitur" class="py-16 bg-white">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="text-center mb-12">
                            <h2 class="text-3xl font-bold text-gray-900">Fitur Unggulan LaporCepat</h2>
                            <p class="mt-4 text-lg text-gray-600">Kami menyediakan berbagai kemudahan untuk Anda.</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="bg-gray-50 p-8 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300">
                                <div class="flex items-center justify-center h-16 w-16 rounded-full feature-icon mb-6">
                                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-3">Pelaporan Mudah & Cepat</h3>
                                <p class="text-gray-600">Laporkan masalah Anda hanya dengan beberapa langkah mudah melalui platform kami yang intuitif.</p>
                            </div>
                            <div class="bg-gray-50 p-8 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300">
                                <div class="flex items-center justify-center h-16 w-16 rounded-full feature-icon mb-6">
                                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-3">Pantau Status Real-time</h3>
                                <p class="text-gray-600">Lihat perkembangan status laporan Anda secara transparan kapan saja dan di mana saja.</p>
                            </div>
                            <div class="bg-gray-50 p-8 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300">
                                <div class="flex items-center justify-center h-16 w-16 rounded-full feature-icon mb-6">
                                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-3">Tanggapan Cepat & Terukur</h3>
                                <p class="text-gray-600">Dapatkan tanggapan dari pihak terkait dengan cepat dan proses yang terukur.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="cara-kerja" class="py-16 bg-gray-100">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="text-center mb-12">
                            <h2 class="text-3xl font-bold text-gray-900">Bagaimana LaporCepat Bekerja?</h2>
                            <p class="mt-4 text-lg text-gray-600">Proses pelaporan yang sederhana dan efektif.</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                            <div class="flex flex-col items-center text-center p-6">
                                <div class="flex items-center justify-center h-20 w-20 rounded-full bg-blue-500 text-white text-2xl font-bold mb-4 ring-4 ring-blue-200">1</div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Daftar/Masuk</h3>
                                <p class="text-gray-600">Buat akun atau masuk jika sudah memiliki akun.</p>
                            </div>
                            <div class="flex flex-col items-center text-center p-6">
                                <div class="flex items-center justify-center h-20 w-20 rounded-full bg-blue-500 text-white text-2xl font-bold mb-4 ring-4 ring-blue-200">2</div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Buat Laporan</h3>
                                <p class="text-gray-600">Isi detail keluhan Anda dengan lengkap dan lampirkan bukti jika ada.</p>
                            </div>
                            <div class="flex flex-col items-center text-center p-6">
                                <div class="flex items-center justify-center h-20 w-20 rounded-full bg-blue-500 text-white text-2xl font-bold mb-4 ring-4 ring-blue-200">3</div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Verifikasi & Proses</h3>
                                <p class="text-gray-600">Laporan Anda akan diverifikasi dan diproses oleh petugas terkait.</p>
                            </div>
                            <div class="flex flex-col items-center text-center p-6">
                                <div class="flex items-center justify-center h-20 w-20 rounded-full bg-blue-500 text-white text-2xl font-bold mb-4 ring-4 ring-blue-200">4</div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Dapatkan Tanggapan</h3>
                                <p class="text-gray-600">Pantau status dan terima tanggapan atas laporan Anda.</p>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

                <section id="laporan-selesai" class="py-20 bg-gray-50 dark:bg-gray-950/50">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="text-center mb-16">
                            <h class="text-3xl font-bold text-gray-900">Hasil Laporan Aduan Warga</h>
                            <p class="mt-4 text-lg text-gray-300">Beberapa contoh keluhan masyarakat yang telah berhasil kami tindak lanjuti.</p>
                        </div>

                        @if(isset($laporanSelesai) && $laporanSelesai->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                @foreach($laporanSelesai as $laporan)
                                <div class="card-laporan flex flex-col">
                                    <div class="h-48 w-full overflow-hidden">
                                        @if($laporan->lampirans->first())
                                            <img src="{{ $laporan->lampirans->first()->file_url }}" alt="Lampiran {{ Str::limit($laporan->judul, 20) }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="h-full w-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="p-6 flex-grow flex flex-col">
                                        <div class="flex justify-between items-center mb-2">
                                            <p class="text-sm font-bold text-indigo-600 dark:text-indigo-400">{{ $laporan->kategori->nama_kategori ?? 'Umum' }}</p>
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100">Selesai</span>
                                        </div>
                                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100 truncate" title="{{ $laporan->judul }}">{{ Str::limit($laporan->judul, 45) }}</h4>

                                        <div class="mt-auto pt-4">
                                            @php
                                                $tanggapanPublik = $laporan->tanggapans->where('jenis_tanggapan', 'publik')->sortByDesc('created_at')->first();
                                            @endphp
                                            @if($tanggapanPublik)
                                            <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                                                <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-3">
                                                    <strong>Tanggapan Petugas:</strong> <span class="italic">"{{ $tanggapanPublik->isi_tanggapan }}"</span>
                                                </p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            {{-- TAMPILAN BARU SAAT TIDAK ADA LAPORAN SELESAI --}}
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg text-center py-16 px-6">
                                <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-4 text-xl font-semibold text-gray-900 dark:text-white">Belum Ada Laporan untuk Ditampilkan</h3>
                                <p class="mt-2 text-md text-gray-500 dark:text-gray-400">
                                    Saat ini belum ada laporan pengaduan yang telah selesai ditangani. <br>
                                    Cek kembali nanti untuk melihat hasil kerja kami!
                                </p>
                            </div>
                        @endif
                    </div>
                </section>

            <footer class="bg-gray-800 text-white py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <p class="text-lg">&copy; {{ date('Y') }} LaporCepat. Semua Hak Cipta Dilindungi.</p>
                    <p class="mt-2 text-sm text-gray-400">Layanan Pengaduan Masyarakat Online Terpercaya.</p>
                    <div class="mt-4">
                        <a href="{{ route('panduan.bantuan') }}" class="text-gray-400 hover:text-white mx-2">Kebijakan Privasi</a>
                        <span class="text-gray-500">|</span>
                        <a href="{{ route('panduan.bantuan') }}" class="text-gray-400 hover:text-white mx-2">Syarat & Ketentuan</a>
                    </div>
                </div>
            </footer>
        </div>
        <script>
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const openIcon = mobileMenuButton.querySelector('svg:not(.hidden)');
            const closeIcon = mobileMenuButton.querySelector('svg.hidden');

            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                openIcon.classList.toggle('hidden');
                closeIcon.classList.toggle('hidden');
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                       // Adjust for fixed header height if necessary
                        const headerOffset = document.querySelector('header').offsetHeight;
                        const elementPosition = targetElement.getBoundingClientRect().top;
                        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: "smooth"
                        });

                        // Close mobile menu if open
                        if (!mobileMenu.classList.contains('hidden')) {
                            mobileMenu.classList.add('hidden');
                            openIcon.classList.remove('hidden');
                            closeIcon.classList.add('hidden');
                        }
                    }
                });
            });
        </script>
    </body>
</html>
