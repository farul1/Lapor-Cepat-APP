<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Selamat datang di <b>Panel Admin, {{ Auth::user()->name }}!</b> Kelola laporan pengaduan masyarakat di sini.
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-800">Total Pengaduan</h3>
                    <p class="text-4xl font-bold text-blue-600">{{ $totalPengaduan }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-800">Menunggu Verifikasi</h3>
                    <p class="text-4xl font-bold text-gray-600">{{ $menungguVerifikasi }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-800">Diproses</h3>
                    <p class="text-4xl font-bold text-yellow-600">{{ $diproses }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-800">Selesai</h3>
                    <p class="text-4xl font-bold text-green-600">{{ $selesai }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-800">Ditolak</h3>
                    <p class="text-4xl font-bold text-red-600">{{ $ditolak }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Pengaduan Terbaru</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelapor</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Lapor</th>
                                    <th scope="col" class="relative px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($latestPengaduans as $pengaduan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ Str::limit($pengaduan->judul, 50) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pengaduan->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{
                                                $pengaduan->status == 'menunggu_verifikasi' ? 'bg-gray-100 text-gray-800' :
                                                ($pengaduan->status == 'diterima' ? 'bg-blue-100 text-blue-800' :
                                                ($pengaduan->status == 'diproses' ? 'bg-yellow-100 text-yellow-800' :
                                                ($pengaduan->status == 'selesai' ? 'bg-green-100 text-green-800' :
                                                ($pengaduan->status == 'ditolak' ? 'bg-red-100 text-red-800' : ''))))
                                            }}">
                                                {{ ucfirst(str_replace('_', ' ', $pengaduan->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pengaduan->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.pengaduan.show', $pengaduan->slug) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada pengaduan terbaru.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 text-right">
                        <a href="{{ route('admin.pengaduan.index') }}" class="text-blue-600 hover:underline">Lihat Semua Pengaduan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
