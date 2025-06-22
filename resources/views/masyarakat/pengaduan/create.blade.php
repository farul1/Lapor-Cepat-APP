<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-light">
            {{ __('Buat Laporan Pengaduan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    {{-- Notifikasi Sukses/Error --}}
                    @if (session('success'))
                        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 dark:bg-green-700 dark:text-green-100 dark:border-green-600" role="alert">
                            <p class="font-bold">Sukses!</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 dark:bg-red-700 dark:text-red-100 dark:border-red-600" role="alert">
                            <p class="font-bold">Error!</p>
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 dark:bg-red-700 dark:text-red-100 dark:border-red-600" role="alert">
                            <p class="font-bold">Harap perbaiki kesalahan berikut:</p>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('masyarakat.pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="judul" :value="__('Judul Laporan')" class="dark:text-gray-300" />
                            <x-text-input id="judul" class="block mt-1 w-full dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" type="text" name="judul" :value="old('judul')" required autofocus placeholder="Contoh: Jalan Rusak di Depan Pasar" />
                            <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="isi_laporan" :value="__('Isi Laporan / Deskripsi Keluhan')" class="dark:text-gray-300" />
                            <textarea name="isi_laporan" id="isi_laporan" rows="6" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" required placeholder="Jelaskan detail keluhan Anda di sini...">{{ old('isi_laporan') }}</textarea>
                            <x-input-error :messages="$errors->get('isi_laporan')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="kategori_id" :value="__('Kategori Laporan (Opsional)')" class="dark:text-gray-300" />
                            <select name="kategori_id" id="kategori_id" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                <option value="">Pilih Kategori</option>
                                @if(isset($kategoris) && $kategoris->count() > 0)
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="" disabled>Belum ada kategori tersedia</option>
                                @endif
                            </select>
                            <x-input-error :messages="$errors->get('kategori_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="tanggal_kejadian" :value="__('Tanggal Kejadian (Opsional)')" class="dark:text-gray-300" />
                            <x-text-input id="tanggal_kejadian" class="block mt-1 w-full dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" type="date" name="tanggal_kejadian" :value="old('tanggal_kejadian')" />
                            <x-input-error :messages="$errors->get('tanggal_kejadian')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="lokasi_text" :value="__('Lokasi Kejadian (Alamat Teks)')" class="dark:text-gray-300" />
                            <x-text-input id="lokasi_text" class="block mt-1 w-full dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" type="text" name="lokasi_text" :value="old('lokasi_text')" required placeholder="Contoh: Jl. Merdeka No. 10, RT 01 RW 02, Kel. Sukamaju, Kec. Aman" />
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Berikan alamat selengkap mungkin.</p>
                            <x-input-error :messages="$errors->get('lokasi_text')" class="mt-2" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Koordinat GPS (Opsional)</label>
                            <div class="flex items-center space-x-2 mt-1">
                                <x-text-input type="text" name="latitude" id="latitude" placeholder="Latitude" class="block w-1/2 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" :value="old('latitude')" />
                                <x-text-input type="text" name="longitude" id="longitude" placeholder="Longitude" class="block w-1/2 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" :value="old('longitude')" />
                            </div>
                            <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
                            <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
                            <button type="button" id="getLocationBtn" class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800">
                                <svg class="-ml-1 mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                                Gunakan Lokasi Saya Saat Ini
                            </button>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400" id="locationStatus">Klik tombol di atas untuk mendapatkan lokasi otomatis.</p>
                        </div>

                        <div>
                            <x-input-label for="lampiran" :value="__('Lampirkan Bukti Pendukung (Foto/Video)')" class="dark:text-gray-300" />
                            <input type="file" name="lampiran[]" id="lampiran" multiple class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 mt-1" accept="image/*,video/*">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">format file (JPG, PNG, MP4, MOV). Ukuran maksimal 25MB per file.</p>
                            <div id="file-preview" class="mt-2 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3"></div>
                            <x-input-error :messages="$errors->get('lampiran')" class="mt-2" />
                            <x-input-error :messages="$errors->get('lampiran.*')" class="mt-2" /> {{-- Untuk error per file --}}
                        </div>

                        <div class="mt-8 flex justify-end">
                            <a href="{{ route('dashboard') }}" class="mr-3 inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Batal
                            </a>
                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                                <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                Kirim Laporan
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

        @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log("DEBUG: DOMContentLoaded event fired. Script LaporCepat dimulai."); // DEBUG 1

        const getLocationBtn = document.getElementById('getLocationBtn');
        const lampiranInput = document.getElementById('lampiran'); // Kita biarkan ini, fokus ke geolocation dulu

        console.log("DEBUG: Tombol getLocationBtn elemen:", getLocationBtn); // DEBUG 2

        if (getLocationBtn) {
            console.log("DEBUG: Tombol getLocationBtn ditemukan. Menambahkan event listener..."); // DEBUG 3
            getLocationBtn.addEventListener('click', function() {
                console.log("DEBUG: Tombol getLocationBtn DIKLIK!"); // DEBUG 4

                const statusDiv = document.getElementById('locationStatus');
                const latitudeInput = document.getElementById('latitude');
                const longitudeInput = document.getElementById('longitude');

                if (!statusDiv || !latitudeInput || !longitudeInput) {
                    console.error("DEBUG: Salah satu elemen (statusDiv, latitudeInput, longitudeInput) tidak ditemukan!");
                    return;
                }

                statusDiv.textContent = 'Mencari lokasi...';
                latitudeInput.value = '';
                longitudeInput.value = '';

                console.log("DEBUG: Memeriksa navigator.geolocation..."); // DEBUG 5
                if (navigator.geolocation) {
                    console.log("DEBUG: navigator.geolocation DIDUKUNG. Memanggil getCurrentPosition..."); // DEBUG 6
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            console.log("DEBUG: getCurrentPosition SUKSES", position); // DEBUG 7
                            latitudeInput.value = position.coords.latitude.toFixed(7);
                            longitudeInput.value = position.coords.longitude.toFixed(7);
                            statusDiv.textContent = 'Lokasi berhasil ditemukan: Lat: ' + position.coords.latitude.toFixed(5) + ', Long: ' + position.coords.longitude.toFixed(5);
                        },
                        (error) => {
                            console.error("DEBUG: getCurrentPosition GAGAL", error); // DEBUG 8
                            let errorMessage = 'Gagal mendapatkan lokasi. ';
                            switch(error.code) {
                                case error.PERMISSION_DENIED:
                                    errorMessage += "Anda menolak permintaan izin lokasi.";
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    errorMessage += "Informasi lokasi tidak tersedia.";
                                    break;
                                case error.TIMEOUT:
                                    errorMessage += "Permintaan lokasi melewati batas waktu.";
                                    break;
                                case error.UNKNOWN_ERROR:
                                default:
                                    errorMessage += "Terjadi kesalahan yang tidak diketahui ("+error.code+"). " + error.message;
                                    break;
                            }
                            statusDiv.textContent = errorMessage;
                            console.error("Error getting location details: ", error.code, error.message);
                        },
                        {
                            enableHighAccuracy: true,
                            timeout: 15000,
                            maximumAge: 0
                        }
                    );
                } else {
                    console.error("DEBUG: navigator.geolocation TIDAK DIDUKUNG."); // DEBUG 9
                    statusDiv.textContent = 'Geolocation tidak didukung oleh browser Anda.';
                }
            });
            console.log("DEBUG: Event listener SELESAI ditambahkan ke getLocationBtn."); // DEBUG 10
        } else {
            console.error("DEBUG: Tombol dengan ID 'getLocationBtn' TIDAK ditemukan!"); // DEBUG 11
        }

        // ... (kode untuk lampiranInput biarkan saja dulu) ...
        if (lampiranInput) {
            lampiranInput.addEventListener('change', function(event) {
                // ... (isi fungsi preview lampiran seperti sebelumnya) ...
                const previewContainer = document.getElementById('file-preview');
                previewContainer.innerHTML = '';

                const files = event.target.files;
                if (files && files.length > 0) {
                    const maxFiles = 5;
                    if (files.length > maxFiles) {
                        alert(`Anda hanya dapat mengunggah maksimal ${maxFiles} file.`);
                        lampiranInput.value = "";
                        return;
                    }

                    Array.from(files).forEach(file => {
                        const fileType = file.type;
                        const reader = new FileReader();
                        const fileSizeMB = (file.size / (1024*1024)).toFixed(2);

                        if (fileSizeMB > 25) {
                            alert(`Ukuran file "${file.name}" (${fileSizeMB} MB) melebihi batas maksimal 25MB.`);
                            lampiranInput.value = "";
                            previewContainer.innerHTML = '';
                            return;
                        }

                        const fileDiv = document.createElement('div');
                        fileDiv.classList.add('relative', 'border', 'dark:border-gray-600', 'rounded-md', 'p-2', 'flex', 'flex-col', 'items-center', 'justify-center');

                        if (fileType.startsWith('image/')) {
                            reader.onload = (e) => {
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.classList.add('w-full', 'h-24', 'object-cover', 'rounded-md', 'mb-1');
                                fileDiv.appendChild(img);
                            };
                            reader.readAsDataURL(file);
                        } else if (fileType.startsWith('video/')) {
                            const videoIcon = document.createElement('div');
                            videoIcon.classList.add('w-full', 'h-24', 'flex', 'items-center', 'justify-center', 'bg-gray-100', 'dark:bg-gray-700', 'rounded-md', 'mb-1');
                            videoIcon.innerHTML = `<svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>`;
                            fileDiv.appendChild(videoIcon);
                        } else {
                            const fileIcon = document.createElement('div');
                            fileIcon.classList.add('w-full', 'h-24', 'flex', 'items-center', 'justify-center', 'bg-gray-100', 'dark:bg-gray-700', 'rounded-md', 'mb-1');
                            fileIcon.innerHTML = `<svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V8a2 2 0 00-2-2h-5L9 4H4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>`;
                            fileDiv.appendChild(fileIcon);
                        }
                        const fileNameText = document.createElement('p');
                        fileNameText.classList.add('text-xs', 'text-gray-600', 'dark:text-gray-400', 'truncate', 'w-full', 'text-center');
                        fileNameText.textContent = file.name + ` (${fileSizeMB} MB)`;
                        fileDiv.appendChild(fileNameText);
                        previewContainer.appendChild(fileDiv);
                    });
                } else {
                     previewContainer.innerHTML = '';
                }
            });
        }
    });
    </script>
    @endpush
</x-app-layout>
