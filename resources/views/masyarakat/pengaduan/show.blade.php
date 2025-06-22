<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Laporan Pengaduan: ') }} #{{ str_pad($pengaduan->id, 6, '0', STR_PAD_LEFT) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-start">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pengaduan->judul }}</h3>
                            @php
                                $statusClass = ''; // Logika untuk warna status
                                if ($pengaduan->status == 'menunggu_verifikasi') $statusClass = 'bg-gray-200 text-gray-800';
                                elseif ($pengaduan->status == 'diterima') $statusClass = 'bg-blue-200 text-blue-800';
                                elseif ($pengaduan->status == 'diproses') $statusClass = 'bg-yellow-200 text-yellow-800';
                                elseif ($pengaduan->status == 'selesai') $statusClass = 'bg-green-200 text-green-800';
                                elseif ($pengaduan->status == 'ditolak') $statusClass = 'bg-red-200 text-red-800';
                            @endphp
                            <span class="px-4 py-1.5 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ ucfirst(str_replace('_', ' ', $pengaduan->status)) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Dilaporkan pada: {{ $pengaduan->created_at->format('d M Y, H:i') }}
                            @if($pengaduan->kategori)
                                <span class="mx-1">•</span> Kategori: {{ $pengaduan->kategori->nama_kategori }}
                            @endif
                        </p>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Isi Laporan:</h4>
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $pengaduan->isi_laporan }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-1">Tanggal Kejadian:</h4>
                            <p class="text-gray-700 dark:text-gray-300">{{ $pengaduan->tanggal_kejadian ? \Carbon\Carbon::parse($pengaduan->tanggal_kejadian)->format('d M Y') : '-' }}</p>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-1">Lokasi Kejadian:</h4>
                            <p class="text-gray-700 dark:text-gray-300">{{ $pengaduan->lokasi_text }}</p>
                            {{-- INI BAGIAN UNTUK LINK PETA --}}
                            @if($pengaduan->latitude && $pengaduan->longitude)
                            <a href="https://www.google.com/maps?q={{ $pengaduan->latitude }},{{ $pengaduan->longitude }}" target="_blank" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                (Lihat di Peta Google: {{ number_format($pengaduan->latitude, 5) }}, {{ number_format($pengaduan->longitude, 5) }})
                            </a>
                            @endif
                        </div>
                    </div>

                    @if($pengaduan->lampirans->count() > 0)
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">Lampiran:</h4>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @foreach($pengaduan->lampirans as $lampiran)
                                <div class="rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                                    @if($lampiran->isImage())
                                        {{-- Untuk Fancybox, pastikan JS dan CSS Fancybox sudah di-include --}}
                                        <a href="{{ $lampiran->file_url }}" data-fancybox="gallery" data-caption="{{ $lampiran->file_name_original }}">
                                            <img src="{{ $lampiran->file_url }}" alt="{{ $lampiran->file_name_original }}" class="w-full h-32 object-cover hover:opacity-80 transition-opacity">
                                        </a>
                                    @elseif($lampiran->isVideo())
                                        {{-- Tampilan untuk video --}}
                                        <a href="{{ $lampiran->file_url }}" target="_blank" class="flex flex-col items-center justify-center w-full h-32 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                            <svg class="w-10 h-10 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                                            <span class="mt-1 text-xs text-gray-600 dark:text-gray-300 px-1 text-center truncate">{{ $lampiran->file_name_original }}</span>
                                        </a>
                                    @else
                                        {{-- Tampilan untuk file lain --}}
                                        <a href="{{ $lampiran->file_url }}" target="_blank" class="flex flex-col items-center justify-center w-full h-32 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                            <svg class="w-10 h-10 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V8a2 2 0 00-2-2h-5L9 4H4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                                            <span class="mt-1 text-xs text-gray-600 dark:text-gray-300 px-1 text-center truncate">{{ $lampiran->file_name_original }}</span>
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($pengaduan->status == 'ditolak' && $pengaduan->alasan_ditolak)
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-700 rounded-lg">
                        <h4 class="text-lg font-semibold text-red-700 dark:text-red-200 mb-2">Alasan Penolakan:</h4>
                        <p class="text-red-600 dark:text-red-300">{{ $pengaduan->alasan_ditolak }}</p>
                    </div>
                    @endif

                    @if($pengaduan->tanggapans->where('jenis_tanggapan', 'publik')->count() > 0)
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">Tanggapan dari Petugas:</h4>
                        <div class="space-y-4">
                        @foreach($pengaduan->tanggapans->where('jenis_tanggapan', 'publik')->sortByDesc('created_at') as $tanggapan)
                            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $tanggapan->isi_tanggapan }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                    Ditanggapi oleh: {{ $tanggapan->admin->name }} (Admin) pada {{ $tanggapan->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                        @endforeach
                        </div>
                    </div>
                    @elseif($pengaduan->status != 'menunggu_verifikasi' && $pengaduan->status != 'ditolak')
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-lg text-center">
                        <p class="text-sm text-blue-700 dark:text-blue-300">Belum ada tanggapan publik dari petugas untuk laporan ini.</p>
                    </div>
                    @endif

                    <div class="mt-8">
                        <a href="{{ route('masyarakat.pengaduan.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
                            Kembali ke Daftar Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Jika Anda menggunakan Fancybox untuk galeri gambar --}}
    @push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
      Fancybox.bind("[data-fancybox]", {
        // Opsi kustom Fancybox Anda
      });
    </script>
    @endpush
</x-app-layout>
