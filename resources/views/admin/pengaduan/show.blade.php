<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-light">
            {{ __('Detail Laporan Pengaduan: ') }} #{{ str_pad($pengaduan->id, 6, '0', STR_PAD_LEFT) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 dark:bg-green-700 dark:text-green-100 dark:border-green-600 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Sukses!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 dark:bg-red-700 dark:text-red-100 dark:border-red-600 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                     @if ($errors->has('debug'))
                        <span class="block sm:inline text-xs">{{ $errors->first('debug') }}</span>
                    @endif
                </div>
            @endif
             @if ($errors->any() && !$errors->has('debug'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Oops! Ada kesalahan validasi:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Kolom Kiri: Detail Laporan --}}
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between items-start">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pengaduan->judul }}</h3>
                                @php
                                    $statusClass = '';
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
                                Oleh: <a href="{{ route('admin.users.show', $pengaduan->user->id) }}" class="text-blue-600 hover:underline">{{ $pengaduan->user->name }}</a> ({{ $pengaduan->user->email }})
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Dilaporkan pada: {{ $pengaduan->created_at->format('d M Y, H:i') }}
                                @if($pengaduan->kategori)
                                    <span class="mx-1">&bull;</span> Kategori: {{ $pengaduan->kategori->nama_kategori }}
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
                                @if($pengaduan->latitude && $pengaduan->longitude)
                                <a href="https://www.google.com/maps?q={{ $pengaduan->latitude }},{{ $pengaduan->longitude }}" target="_blank" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                    (Lihat di Peta: {{ $pengaduan->latitude }}, {{ $pengaduan->longitude }})
                                </a>
                                @endif
                            </div>
                        </div>

                        @if($pengaduan->lampirans->count() > 0)
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">Lampiran:</h4>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 gap-4">
                                @foreach($pengaduan->lampirans as $lampiran)
                                    <div class="rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                                        @if($lampiran->isImage())
                                            <a href="{{ $lampiran->file_url }}" target="_blank" data-fancybox="gallery" data-caption="{{ $lampiran->file_name_original }}">
                                                <img src="{{ $lampiran->file_url }}" alt="{{ $lampiran->file_name_original }}" class="w-full h-32 object-cover hover:opacity-80 transition-opacity">
                                            </a>
                                        @elseif($lampiran->isVideo())
                                            <a href="{{ $lampiran->file_url }}" target="_blank" class="flex flex-col items-center justify-center w-full h-32 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors p-2">
                                                <svg class="w-10 h-10 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                                                <span class="mt-1 text-xs text-gray-600 dark:text-gray-300 text-center truncate w-full">{{ $lampiran->file_name_original }}</span>
                                            </a>
                                        @else
                                            <a href="{{ $lampiran->file_url }}" target="_blank" class="flex flex-col items-center justify-center w-full h-32 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors p-2">
                                                <svg class="w-10 h-10 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V8a2 2 0 00-2-2h-5L9 4H4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                                                <span class="mt-1 text-xs text-gray-600 dark:text-gray-300 text-center truncate w-full">{{ $lampiran->file_name_original }}</span>
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($pengaduan->status == 'ditolak' && $pengaduan->alasan_ditolak)
                        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-lg">
                            <h4 class="text-lg font-semibold text-red-700 dark:text-red-200 mb-2">Alasan Penolakan:</h4>
                            <p class="text-red-600 dark:text-red-300">{{ $pengaduan->alasan_ditolak }}</p>
                        </div>
                        @endif

                        @if($pengaduan->tanggapans->count() > 0)
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">Riwayat Tanggapan:</h4>
                            <div class="space-y-4">
                            @foreach($pengaduan->tanggapans->sortByDesc('created_at') as $tanggapan)
                                <div class="p-4 rounded-lg border {{ $tanggapan->jenis_tanggapan == 'publik' ? 'bg-blue-50 dark:bg-blue-900/30 border-blue-200 dark:border-blue-700' : 'bg-gray-50 dark:bg-gray-700/50 border-gray-200 dark:border-gray-600' }}">
                                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $tanggapan->isi_tanggapan }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                        Oleh: {{ $tanggapan->admin->name }} (Admin) pada {{ $tanggapan->created_at->format('d M Y, H:i') }}
                                        <span class="ml-2 px-2 py-0.5 text-xs font-semibold rounded-full {{ $tanggapan->jenis_tanggapan == 'publik' ? 'bg-blue-200 text-blue-800' : 'bg-gray-200 text-gray-800' }}">
                                            {{ ucfirst($tanggapan->jenis_tanggapan) }}
                                        </span>
                                    </p>
                                </div>
                            @endforeach
                            </div>
                        </div>
                        @endif
                        <div class="mt-8">
                            <a href="{{ route('admin.pengaduan.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Aksi Admin --}}
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Update Status & Beri Tanggapan</h3>
                            <form action="{{ route('admin.pengaduan.update_status', $pengaduan->slug) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ubah Status Ke:</label>
                                    <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                                        <option value="diterima" {{ $pengaduan->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                        <option value="diproses" {{ $pengaduan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="ditolak" {{ $pengaduan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>

                                <div class="mb-4" id="alasan_ditolak_div" style="{{ old('status', $pengaduan->status) == 'ditolak' ? '' : 'display:none;' }}">
                                    <label for="alasan_ditolak" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alasan Penolakan (Wajib jika status Ditolak):</label>
                                    <textarea id="alasan_ditolak" name="alasan_ditolak" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('alasan_ditolak', $pengaduan->alasan_ditolak) }}</textarea>
                                </div>

                                <div class="mb-4">
                                    <label for="isi_tanggapan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggapan Publik (Opsional):</label>
                                    <textarea id="isi_tanggapan" name="isi_tanggapan" rows="4" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Berikan tanggapan yang akan dilihat oleh pelapor...">{{ old('isi_tanggapan') }}</textarea>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tanggapan ini akan dikirimkan ke pelapor dan ditampilkan di detail laporannya.</p>
                                </div>

                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Update Status & Kirim Tanggapan
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                             <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Aksi Lain</h3>
                            <form action="{{ route('admin.pengaduan.destroy', $pengaduan->slug) }}" method="POST" onsubmit="return confirm('PERHATIAN: Apakah Anda benar-benar yakin ingin menghapus laporan ini? Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait laporan ini termasuk lampiran dan tanggapan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Hapus Laporan Ini
                                </button>
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 text-center">Gunakan dengan sangat hati-hati. Disarankan untuk tidak menghapus laporan demi transparansi.</p>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
      Fancybox.bind("[data-fancybox]", {
        // Your custom options
      });

      document.getElementById('status').addEventListener('change', function() {
          var alasanDitolakDiv = document.getElementById('alasan_ditolak_div');
          var alasanDitolakTextarea = document.getElementById('alasan_ditolak');
          if (this.value === 'ditolak') {
              alasanDitolakDiv.style.display = 'block';
              alasanDitolakTextarea.setAttribute('required', 'required');
          } else {
              alasanDitolakDiv.style.display = 'none';
              alasanDitolakTextarea.removeAttribute('required');
          }
      });
      // Trigger change on page load to set initial state
      document.getElementById('status').dispatchEvent(new Event('change'));
    </script>
    @endpush
</x-app-layout>
