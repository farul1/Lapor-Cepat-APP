<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan; // Pastikan model Pengaduan di-import
use Illuminate\Support\Facades\Auth; // Import Auth Facade

class WelcomeController extends Controller
{
    /**
     * Menampilkan halaman selamat datang atau mengarahkan pengguna yang sudah login.
     */
    public function index()
    {
        // Jika pengguna sudah login, langsung arahkan ke dashboard yang sesuai.
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                return redirect()->route('admin.dashboard');
            } else { // Asumsi role lainnya adalah masyarakat
                return redirect()->route('dashboard');
            }
        }

        // Jika pengguna adalah tamu, lanjutkan untuk mengambil data laporan.
        $laporanSelesai = Pengaduan::where('status', 'selesai')
                                    ->with(['user', 'kategori', 'lampirans', 'tanggapans' => function ($query) {
                                        // Ambil hanya tanggapan publik dari admin untuk ditampilkan
                                        $query->where('jenis_tanggapan', 'publik')->with('admin')->orderBy('created_at', 'desc');
                                    }])
                                    ->orderBy('updated_at', 'desc') // Urutkan berdasarkan kapan laporan selesai
                                    ->take(3) // Batasi hanya 3 laporan
                                    ->get();

        return view('welcome', compact('laporanSelesai'));
    }
}
