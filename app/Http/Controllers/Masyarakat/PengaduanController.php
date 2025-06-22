<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\KategoriLaporan;
use App\Models\LampiranPengaduan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\Notifikasi;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduans = auth()->user()->pengaduans()->orderBy('created_at', 'desc')->paginate(10);
        return view('masyarakat.pengaduan.index', compact('pengaduans'));
    }

    public function create()
    {
        $kategoris = KategoriLaporan::all();
        return view('masyarakat.pengaduan.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_laporan' => 'required|string',
            'kategori_id' => ['nullable', Rule::exists('kategori_laporans', 'id')],
            'tanggal_kejadian' => 'nullable|date',
            'lokasi_text' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'lampiran.*' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov|max:25000', // Max 25MB per file
        ], [
            'lampiran.*.mimes' => 'Hanya format gambar (jpg, jpeg, png) atau video (mp4, mov) yang diizinkan.',
            'lampiran.*.max' => 'Ukuran file lampiran maksimal 25MB.',
        ]);

        DB::beginTransaction();
        try {
            $pengaduan = Pengaduan::create([
                'user_id' => auth()->id(),
                'judul' => $request->judul,
                'isi_laporan' => $request->isi_laporan,
                'kategori_id' => $request->kategori_id,
                'tanggal_kejadian' => $request->tanggal_kejadian,
                'lokasi_text' => $request->lokasi_text,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => 'menunggu_verifikasi',
            ]);

            if ($request->hasFile('lampiran')) {
                foreach ($request->file('lampiran') as $file) {
                    $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('public/lampiran_pengaduan', $fileName);

                    LampiranPengaduan::create([
                        'pengaduan_id' => $pengaduan->id,
                        'file_path' => str_replace('public/', '', $filePath),
                        'file_name_original' => $file->getClientOriginalName(),
                        'file_mime_type' => $file->getClientMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }

            Notifikasi::create([
                'user_id' => auth()->id(),
                'pengaduan_id' => $pengaduan->id,
                'judul_notifikasi' => 'Laporan Berhasil Dibuat',
                'pesan_notifikasi' => 'Laporan Anda dengan judul "' . $pengaduan->judul . '" berhasil kami terima dan sedang menunggu verifikasi.',
                'link_aksi' => route('masyarakat.pengaduan.show', $pengaduan->slug),
            ]);

            DB::commit();
            return redirect()->route('masyarakat.pengaduan.index')->with('success', 'Laporan Anda berhasil dikirim!');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log the error for debugging
            \Log::error('Error creating pengaduan: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan saat mengirim laporan. Silakan coba lagi.')->withErrors(['debug' => $e->getMessage()]);
        }
    }

    public function show(Pengaduan $pengaduan)
    {
        // Pastikan hanya user yang bersangkutan yang bisa melihat laporannya
        if ($pengaduan->user_id !== auth()->id()) {
            abort(403);
        }
        return view('masyarakat.pengaduan.show', compact('pengaduan'));
    }
}
