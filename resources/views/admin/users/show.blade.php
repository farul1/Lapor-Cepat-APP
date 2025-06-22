<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Pengguna: ') }} <span class="text-indigo-600 dark:text-indigo-400">{{ $user->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">

                    {{-- Bagian Informasi Utama Pengguna --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-6 mb-8">
                        {{-- Kolom Kiri: Informasi Akun --}}
                        <div class="md:col-span-2">
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4 border-b pb-3 dark:border-gray-700">
                                Informasi Akun
                            </h3>
                            <dl class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 sm:col-span-1">ID Pengguna</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ $user->id }}</dd>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 sm:col-span-1">Nama Lengkap</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ $user->name }}</dd>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 sm:col-span-1">Alamat Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ $user->email }}</dd>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 sm:col-span-1">Nomor Telepon</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ $user->phone_number ?? '-' }}</dd>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 sm:col-span-1">NIK</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ $user->nik ?? '-' }}</dd>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 sm:col-span-1">Role</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role == 'admin' ? 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100' : 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </dd>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 sm:col-span-1">Tanggal Daftar</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ $user->created_at->format('d F Y, H:i T') }}</dd>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 sm:col-span-1">Email Terverifikasi</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ $user->email_verified_at ? $user->email_verified_at->format('d M Y, H:i') : 'Belum' }}</dd>
                                </div>
                            </dl>
                        </div>

                        {{-- Kolom Kanan: Statistik Pengaduan (jika role masyarakat) --}}
                        @if($user->role == 'masyarakat')
                        <div class="md:col-span-1">
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4 border-b pb-3 dark:border-gray-700">
                                Statistik Pengaduan
                            </h3>
                             <dl class="space-y-4">
                                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-md">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pengaduan Dibuat</dt>
                                    <dd class="text-lg font-semibold text-blue-600 dark:text-blue-400">{{ $user->pengaduans->count() }}</dd>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-md">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Pengaduan Diproses</dt>
                                    <dd class="text-lg font-semibold text-yellow-600 dark:text-yellow-400">{{ $user->pengaduans()->where('status', 'diproses')->count() }}</dd>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-md">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Pengaduan Selesai</dt>
                                    <dd class="text-lg font-semibold text-green-600 dark:text-green-400">{{ $user->pengaduans()->where('status', 'selesai')->count() }}</dd>
                                </div>
                            </dl>
                        </div>
                        @endif
                    </div>

                    {{-- Riwayat Pengaduan Pengguna (jika role masyarakat) --}}
                    @if($user->role == 'masyarakat' && $user->pengaduans->count() > 0)
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4 border-b pb-3 dark:border-gray-700">
                            Riwayat Pengaduan Pengguna (10 Terbaru)
                        </h3>
                        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Judul</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tgl Lapor</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($user->pengaduans()->orderBy('created_at', 'desc')->take(10)->get() as $pengaduan)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">#{{ str_pad($pengaduan->id, 6, '0', STR_PAD_LEFT) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ Str::limit($pengaduan->judul, 35) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                 @php
                                                    $statusClass = '';
                                                    if ($pengaduan->status == 'menunggu_verifikasi') $statusClass = 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100';
                                                    elseif ($pengaduan->status == 'diterima') $statusClass = 'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100';
                                                    elseif ($pengaduan->status == 'diproses') $statusClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-600 dark:text-yellow-100';
                                                    elseif ($pengaduan->status == 'selesai') $statusClass = 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100';
                                                    elseif ($pengaduan->status == 'ditolak') $statusClass = 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100';
                                                @endphp
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                                    {{ ucfirst(str_replace('_', ' ', $pengaduan->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pengaduan->created_at->format('d M Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium">
                                                <a href="{{ route('admin.pengaduan.show', $pengaduan->slug) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-200">Lihat Laporan</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @elseif($user->role == 'masyarakat')
                        <div class="mt-8 text-center py-6 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Belum Ada Pengaduan</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Pengguna ini belum membuat laporan pengaduan.</p>
                        </div>
                        @endif
                    </div>

                    <div class="mt-8 pt-6 border-t dark:border-gray-700 flex flex-col sm:flex-row justify-start space-y-3 sm:space-y-0 sm:space-x-3">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 dark:focus:ring-offset-gray-800">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828zM4 13V4a2 2 0 012-2h4a1 1 0 010 2H6v10h10V9a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2z"></path></svg>
                            Edit Pengguna
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
                            Kembali ke Daftar Pengguna
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
