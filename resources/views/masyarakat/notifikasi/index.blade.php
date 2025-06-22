<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-light">
                {{ __('Notifikasi Saya') }}
            </h2>
            @if($notifikasis->where('is_read', false)->count() > 0)
            <button id="mark-all-read-btn" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                Tandai Semua Sudah Dibaca
            </button>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($notifikasis->count() > 0)
                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700" id="notifikasi-list">
                            @foreach ($notifikasis as $notifikasi)
                                <li class="py-4 {{ !$notifikasi->is_read ? 'bg-blue-50 dark:bg-gray-700/50' : '' }} hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out" data-id="{{ $notifikasi->id }}">
                                    <a href="{{ $notifikasi->link_aksi ?? '#' }}" class="block px-2 sm:px-0" onclick="markAsRead(event, {{ $notifikasi->id }}, '{{ $notifikasi->link_aksi ?? '#' }}')">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                @if(!$notifikasi->is_read)
                                                    <span class="h-2.5 w-2.5 bg-blue-500 rounded-full inline-block" aria-hidden="true"></span>
                                                @else
                                                    <span class="h-2.5 w-2.5 bg-transparent rounded-full inline-block" aria-hidden="true"></span>
                                                @endif
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $notifikasi->judul_notifikasi }}</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $notifikasi->pesan_notifikasi }}</p>
                                            </div>
                                            <div class="flex-shrink-0 self-center">
                                                <p class="text-xs text-gray-400 dark:text-gray-500">{{ $notifikasi->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                         <div class="mt-6">
                            {{ $notifikasis->links() }}
                        </div>
                    @else
                        <div class="text-center py-10">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak Ada Notifikasi</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Anda tidak memiliki notifikasi saat ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        async function markAsRead(event, notifikasiId, linkAksi) {
            event.preventDefault(); // Mencegah navigasi langsung jika kita ingin handle di sini

            const listItem = document.querySelector(`li[data-id="${notifikasiId}"]`);
            const unreadIndicator = listItem ? listItem.querySelector('.bg-blue-500') : null;

            if (listItem && !listItem.classList.contains('marked-as-read')) {
                try {
                    const response = await fetch(`{{ url('/notifikasi') }}/${notifikasiId}/read`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        }
                    });
                    const result = await response.json();
                    if (result.success) {
                        if (unreadIndicator) {
                            unreadIndicator.classList.remove('bg-blue-500');
                            unreadIndicator.classList.add('bg-transparent');
                        }
                        listItem.classList.remove('bg-blue-50', 'dark:bg-gray-700/50');
                        listItem.classList.add('marked-as-read'); // Tandai agar tidak diproses lagi
                        // Update unread count di header jika ada
                        updateUnreadCountHeader();
                    }
                } catch (error) {
                    console.error('Error marking notification as read:', error);
                }
            }
            // Lanjutkan ke link aksi setelah ditandai (atau jika sudah dibaca)
            if (linkAksi && linkAksi !== '#') {
                window.location.href = linkAksi;
            }
        }

        const markAllReadBtn = document.getElementById('mark-all-read-btn');
        if (markAllReadBtn) {
            markAllReadBtn.addEventListener('click', async () => {
                try {
                    const response = await fetch(`{{ route('masyarakat.notifikasi.mark_all_as_read') }}`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        }
                    });
                    const result = await response.json();
                    if (result.success) {
                        document.querySelectorAll('#notifikasi-list li').forEach(item => {
                            const unreadIndicator = item.querySelector('.bg-blue-500');
                            if (unreadIndicator) {
                                unreadIndicator.classList.remove('bg-blue-500');
                                unreadIndicator.classList.add('bg-transparent');
                            }
                            item.classList.remove('bg-blue-50', 'dark:bg-gray-700/50');
                        });
                        markAllReadBtn.style.display = 'none'; // Sembunyikan tombol setelah diklik
                        updateUnreadCountHeader();
                    }
                } catch (error) {
                    console.error('Error marking all notifications as read:', error);
                }
            });
        }

        // Fungsi untuk mengupdate count notifikasi di header (jika ada elemennya)
        async function updateUnreadCountHeader() {
            // Anda perlu elemen di header (misal di navigation.blade.php) dengan id tertentu
            // contoh: <span id="unread-notifications-count" class="ml-2 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full"></span>
            const countElement = document.getElementById('unread-notifications-count');
            if (countElement) {
                 try {
                    const response = await fetch(`{{ route('masyarakat.notifikasi.unread_count') }}`);
                    const data = await response.json();
                    if (data.count > 0) {
                        countElement.textContent = data.count;
                        countElement.style.display = 'inline-block';
                    } else {
                        countElement.style.display = 'none';
                    }
                } catch (error) {
                    console.error('Error fetching unread count:', error);
                }
            }
        }
        // Panggil saat halaman dimuat juga
        // document.addEventListener('DOMContentLoaded', updateUnreadCountHeader);
    </script>
    @endpush
</x-app-layout>
