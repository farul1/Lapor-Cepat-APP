<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengaduan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPengaduan = Pengaduan::count();
        $menungguVerifikasi = Pengaduan::where('status', 'menunggu_verifikasi')->count();
        $diproses = Pengaduan::where('status', 'diproses')->count();
        $selesai = Pengaduan::where('status', 'selesai')->count();
        $ditolak = Pengaduan::where('status', 'ditolak')->count();

        // Ambil 5 pengaduan terbaru
        $latestPengaduans = Pengaduan::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPengaduan',
            'menungguVerifikasi',
            'diproses',
            'selesai',
            'ditolak',
            'latestPengaduans'
        ));
    }
}
