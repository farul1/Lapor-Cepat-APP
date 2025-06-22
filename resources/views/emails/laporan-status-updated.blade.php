@component('mail::message')
# Halo {{ $pengaduan->user->name }},

Kami ingin memberikan informasi terbaru mengenai laporan Anda:

**Judul Laporan:** {{ $pengaduan->judul }}
**Tanggal Lapor:** {{ $pengaduan->created_at->format('d M Y H:i') }}
**Status Baru:** **{{ strtoupper(str_replace('_', ' ', $newStatus)) }}**

@if ($newStatus == 'diterima')
Laporan Anda telah kami terima dan saat ini sedang dalam tahap verifikasi.
@elseif ($newStatus == 'diproses')
Laporan Anda sedang dalam proses penanganan oleh tim terkait. Kami akan segera memberikan pembaruan lebih lanjut.
@elseif ($newStatus == 'selesai')
Laporan Anda telah selesai kami tindaklanjuti. Terima kasih atas partisipasi Anda dalam membantu kami meningkatkan kualitas layanan publik.
@elseif ($newStatus == 'ditolak')
Dengan berat hati kami informasikan bahwa laporan Anda tidak dapat kami proses lebih lanjut.
**Alasan:** {{ $alasanDitolak ?? 'Tidak ada alasan spesifik yang diberikan.' }}
@endif

@if ($tanggapanAdmin)
**Pesan dari Admin:**
{{ $tanggapanAdmin }}
@endif

Anda dapat melihat detail laporan Anda dan pembaruan lebih lanjut melalui link di bawah ini:

@component('mail::button', ['url' => route('masyarakat.pengaduan.show', $pengaduan->slug)])
Lihat Detail Laporan
@endcomponent

Terima kasih atas perhatian dan kerja sama Anda.

Hormat kami,<br>
Tim Layanan Pengaduan {{ config('app.name') }}
@endcomponent
