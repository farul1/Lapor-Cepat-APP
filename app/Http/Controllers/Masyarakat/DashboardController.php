<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Notifikasi;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $totalPengaduan = $user->pengaduans()->count();
        $pengaduanDiproses = $user->pengaduans()->where('status', 'diproses')->count();
        $pengaduanSelesai = $user->pengaduans()->where('status', 'selesai')->count();
        $notifikasiTerbaru = Notifikasi::where('user_id', $user->id)
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();

        return view('masyarakat.dashboard', compact(
            'totalPengaduan',
            'pengaduanDiproses',
            'pengaduanSelesai',
            'notifikasiTerbaru'
        ));
    }
}
