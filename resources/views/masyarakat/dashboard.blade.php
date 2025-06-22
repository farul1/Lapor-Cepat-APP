<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Masyarakat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Selamat datang, <b>{{ Auth::user()->name }}!</b> Suarakan keluhan Anda untuk pelayanan yang lebih baik.
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800">Total Pengaduan</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $totalPengaduan }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800">Sedang Diproses</h3>
                    <p class="text-3xl font-bold text-yellow-600">{{ $pengaduanDiproses }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800">Selesai</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $pengaduanSelesai }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Notifikasi Terbaru</h3>
                    @forelse ($notifikasiTerbaru as $notifikasi)
                        <div class="border-b last:border-b-0 py-2">
                            <a href="{{ $notifikasi->link_aksi ?? '#' }}" class="block {{ $notifikasi->is_read ? 'text-gray-500' : 'font-medium text-gray-800' }}">
                                <p class="text-sm">{{ $notifikasi->judul_notifikasi }}</p>
                                <p class="text-xs text-gray-600">{{ Str::limit($notifikasi->pesan_notifikasi, 80) }}</p>
                                <span class="text-xs text-gray-400">{{ $notifikasi->created_at->diffForHumans() }}</span>
                            </a>
                        </div>
                    @empty
                        <p class="text-gray-500">Belum ada notifikasi.</p>
                    @endforelse
                    <div class="mt-4 text-right">
                        <a href="{{ route('masyarakat.notifikasi.index') }}" class="text-blue-600 hover:underline">Lihat Semua Notifikasi</a>
                    </div>
                </div>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('masyarakat.pengaduan.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M11 3a1 1 0 10-2 0v5H5a1 1 0 100 2h4v5a1 1 0 102 0v-5h4a1 1 0 100-2h-4V3z"></path></svg>
                    Buat Laporan Baru
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
