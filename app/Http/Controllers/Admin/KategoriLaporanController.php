<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriLaporan; // Pastikan Model KategoriLaporan sudah ada
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Untuk membuat slug
use Illuminate\Validation\Rule; // Untuk validasi unique

class KategoriLaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua kategori laporan.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $query = KategoriLaporan::query();

        if ($search) {
            $query->where('nama_kategori', 'like', "%{$search}%");
        }

        $kategoriLaporans = $query->orderBy('nama_kategori')->paginate(10);
        return view('admin.kategori_laporan.index', compact('kategoriLaporans', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk membuat kategori baru.
     */
    public function create()
    {
        return view('admin.kategori_laporan.create');
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan kategori baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_laporans,nama_kategori',
            'deskripsi' => 'nullable|string',
        ]);

        KategoriLaporan::create([
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori), // Otomatis buat slug
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.kategori.index')
                         ->with('success', 'Kategori laporan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * (Opsional) Menampilkan detail satu kategori. Biasanya tidak terlalu diperlukan jika data utama sudah ada di index dan edit.
     */
    public function show(KategoriLaporan $kategori) // Route model binding
    {
        // Jika Anda butuh halaman detail khusus, buat view-nya.
        // return view('admin.kategori_laporan.show', compact('kategori'));
        return redirect()->route('admin.kategori.edit', $kategori); // Atau langsung ke edit
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit kategori.
     */
    public function edit(KategoriLaporan $kategori) // Route model binding
    {
        return view('admin.kategori_laporan.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     * Mengupdate kategori yang ada di database.
     */
    public function update(Request $request, KategoriLaporan $kategori) // Route model binding
    {
        $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategori_laporans', 'nama_kategori')->ignore($kategori->id),
            ],
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->slug = Str::slug($request->nama_kategori); // Update slug jika nama berubah
        $kategori->deskripsi = $request->deskripsi;
        $kategori->save();

        return redirect()->route('admin.kategori.index')
                         ->with('success', 'Kategori laporan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus kategori dari database.
     */
    public function destroy(KategoriLaporan $kategori) // Route model binding
    {

        if ($kategori->pengaduans()->count() > 0) {
            return redirect()->route('admin.kategori.index')
                             ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh beberapa pengaduan. Ubah kategori pada pengaduan tersebut terlebih dahulu atau set kategori_id menjadi NULL pada pengaduan terkait.');
        }

        try {
            $kategori->delete();
            return redirect()->route('admin.kategori.index')
                             ->with('success', 'Kategori laporan berhasil dihapus.');
        } catch (\Exception $e) {
            \Log::error("Error deleting kategori laporan: ".$e->getMessage());
            return redirect()->route('admin.kategori.index')
                             ->with('error', 'Terjadi kesalahan saat menghapus kategori laporan.');
        }
    }
}
