<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            <span class="text-gray-900 dark:text-gray-100">{{ __('Pengaturan Profil Anda') }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-8">
                <aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-3">
                    <nav id="profile-nav" class="space-y-1">
                        {{-- Menu Navigasi Samping --}}
                        <a href="#profile-information"
                           class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 group rounded-md px-3 py-2 flex items-center text-sm font-medium">
                            <svg class="text-gray-500 dark:text-gray-400 flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="truncate">Informasi Profil</span>
                        </a>
                        <a href="#update-password"
                           class="text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100 group rounded-md px-3 py-2 flex items-center text-sm font-medium">
                            <svg class="text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-400 flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span class="truncate">Perbarui Password</span>
                        </a>
                        <a href="#delete-account"
                           class="text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100 group rounded-md px-3 py-2 flex items-center text-sm font-medium">
                            <svg class="text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-400 flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span class="truncate">Hapus Akun</span>
                        </a>
                    </nav>
                </aside>

                <div class="space-y-6 lg:col-span-9">
                    {{-- Bagian Informasi Profil --}}
                    <div id="profile-information" class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    {{-- Bagian Update Password --}}
                    <div id="update-password" class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    {{-- Bagian Hapus Akun --}}
                    <div id="delete-account" class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BAGIAN BARU: SCRIPT UNTUK MENU AKTIF SAAT SCROLL --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sections = document.querySelectorAll('div[id]');
            const navLinks = document.querySelectorAll('#profile-nav a');

            const activeClasses = ['bg-gray-100', 'dark:bg-gray-700', 'text-gray-900', 'dark:text-gray-100'];
            const inactiveClasses = ['text-gray-700', 'dark:text-gray-300', 'hover:bg-gray-50', 'dark:hover:bg-gray-700', 'hover:text-gray-900', 'dark:hover:text-gray-100'];

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const id = entry.target.getAttribute('id');
                        const activeLink = document.querySelector(`#profile-nav a[href="#${id}"]`);

                        // Hapus class 'active' dari semua link
                        navLinks.forEach(link => {
                            link.classList.remove(...activeClasses);
                            link.classList.add(...inactiveClasses);
                        });

                        // Tambahkan class 'active' ke link yang sesuai
                        if (activeLink) {
                            activeLink.classList.add(...activeClasses);
                            activeLink.classList.remove(...inactiveClasses);
                        }
                    }
                });
            }, {
                rootMargin: "-50% 0px -50% 0px", // Menganggap aktif saat section berada di tengah layar
                threshold: 0
            });

            sections.forEach(section => {
                observer.observe(section);
            });

            // Logika untuk smooth scroll ketika link menu samping diklik
            navLinks.forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
