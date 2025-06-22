<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\TanggapanPengaduan;
use App\Models\Notifikasi;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Mail\LaporanStatusUpdated; // Pastikan Mailable ini sudah ada dan benar
use Illuminate\Support\Facades\Mail; // Untuk mengirim email
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Untuk logging

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $statusFilter = $request->get('status');
        // Tambahkan pencarian jika diperlukan
        $searchFilter = $request->get('search');
        $query = Pengaduan::with('user', 'kategori');

        if ($statusFilter && $statusFilter != 'all') {
            $query->where('status', $statusFilter);
        }

        if ($searchFilter) {
            $query->where(function($q) use ($searchFilter) {
                $q->where('judul', 'like', "%{$searchFilter}%")
                  ->orWhereHas('user', function($userQuery) use ($searchFilter) {
                      $userQuery->where('name', 'like', "%{$searchFilter}%");
                  });
            });
        }

        $pengaduans = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.pengaduan.index', compact('pengaduans', 'statusFilter', 'searchFilter'));
    }

    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load('user', 'kategori', 'lampirans', 'tanggapans.admin');
        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'status' => ['required', Rule::in(['diterima', 'diproses', 'selesai', 'ditolak'])],
            'isi_tanggapan' => 'nullable|string', // Tanggapan publik
            'alasan_ditolak' => 'required_if:status,ditolak|string|nullable', // Wajib jika status ditolak
        ]);

        DB::beginTransaction();
        try {
            // $oldStatus = $pengaduan->status; // Tidak digunakan, bisa dihapus jika tidak ada logika khusus
            $newStatus = $request->status;

            $pengaduan->status = $newStatus;
            $pengaduan->alasan_ditolak = ($newStatus == 'ditolak') ? $request->alasan_ditolak : null;
            $pengaduan->save();

            // Simpan tanggapan dari admin (jika ada)
            if ($request->filled('isi_tanggapan')) {
                TanggapanPengaduan::create([
                    'pengaduan_id' => $pengaduan->id,
                    'admin_id' => auth()->id(),
                    'isi_tanggapan' => $request->isi_tanggapan,
                    'jenis_tanggapan' => 'publik', // Admin memberikan tanggapan publik
                ]);
            }

            // Kirim Notifikasi ke User (via email dan di aplikasi)
            $user = $pengaduan->user;
            if (!$user) {
                // Handle kasus jika user tidak ditemukan, meskipun seharusnya tidak terjadi jika relasi benar
                Log::error("User tidak ditemukan untuk pengaduan ID: " . $pengaduan->id);
                DB::rollBack();
                return back()->with('error', 'Data pengguna tidak ditemukan untuk laporan ini.');
            }

            $judulNotifikasi = '';
            $pesanNotifikasi = '';

            if ($newStatus == 'diterima') {
                $judulNotifikasi = 'Laporan Anda Telah Diterima';
                $pesanNotifikasi = 'Laporan Anda dengan judul "' . $pengaduan->judul . '" telah diterima dan sedang dalam tahap verifikasi.';
            } elseif ($newStatus == 'diproses') {
                $judulNotifikasi = 'Laporan Anda Sedang Diproses';
                $pesanNotifikasi = 'Laporan Anda dengan judul "' . $pengaduan->judul . '" saat ini sedang dalam proses penanganan oleh tim terkait.';
            } elseif ($newStatus == 'selesai') {
                $judulNotifikasi = 'Laporan Anda Telah Selesai Ditindaklanjuti';
                $pesanNotifikasi = 'Laporan Anda dengan judul "' . $pengaduan->judul . '" telah berhasil ditindaklanjuti. Terima kasih atas partisipasi Anda.';
            } elseif ($newStatus == 'ditolak') {
                $judulNotifikasi = 'Laporan Anda Ditolak';
                $pesanNotifikasi = 'Laporan Anda dengan judul "' . $pengaduan->judul . '" tidak dapat kami proses. Alasan: ' . ($request->alasan_ditolak ?? 'Tidak ada alasan spesifik');
            }

            // Notifikasi dalam aplikasi
            Notifikasi::create([
                'user_id' => $user->id,
                'pengaduan_id' => $pengaduan->id,
                'judul_notifikasi' => $judulNotifikasi,
                'pesan_notifikasi' => $pesanNotifikasi,
                'link_aksi' => route('masyarakat.pengaduan.show', $pengaduan->slug),
            ]);

            // Kirim Email
            Log::info('[EMAIL SENDING] Mencoba mengirim email notifikasi status ke: ' . $user->email . ' untuk pengaduan ID: ' . $pengaduan->id);
            Mail::to($user->email)->send(new LaporanStatusUpdated($pengaduan, $newStatus, $request->isi_tanggapan, $request->alasan_ditolak));
            Log::info('[EMAIL SENT] Perintah Mail::send untuk LaporanStatusUpdated telah dieksekusi untuk pengaduan ID: ' . $pengaduan->id);

            DB::commit();
            return redirect()->route('admin.pengaduan.show', $pengaduan->slug)->with('success', 'Status laporan berhasil diperbarui dan notifikasi telah dikirim.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating pengaduan status (Pengaduan ID: ' . $pengaduan->id . '): ' . $e->getMessage() . "\nStack Trace:\n" . $e->getTraceAsString());
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui status. Silakan coba lagi.')->withErrors(['debug' => $e->getMessage()]);
        }
    }

    public function destroy(Pengaduan $pengaduan)
    {
        DB::beginTransaction();
        try {
            // Hapus lampiran fisik dari storage terlebih dahulu
            foreach ($pengaduan->lampirans as $lampiran) {
                if (Storage::disk('public')->exists($lampiran->file_path)) { // Pastikan path benar dan file ada
                    Storage::disk('public')->delete($lampiran->file_path);
                } else {
                    Log::warning("File lampiran tidak ditemukan di storage: " . $lampiran->file_path . " untuk pengaduan ID: " . $pengaduan->id);
                }
            }
            $pengaduan->delete(); // Ini akan menghapus lampiran, tanggapan, notifikasi terkait karena onDelete('cascade')

            DB::commit();
            return redirect()->route('admin.pengaduan.index')->with('success', 'Laporan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting pengaduan (Pengaduan ID: ' . $pengaduan->id . '): ' . $e->getMessage() . "\nStack Trace:\n" . $e->getTraceAsString());
            return back()->with('error', 'Terjadi kesalahan saat menghapus laporan.');
        }
    }
}
