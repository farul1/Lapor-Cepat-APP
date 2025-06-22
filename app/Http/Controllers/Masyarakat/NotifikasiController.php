<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasis = auth()->user()->notifikasis()->orderBy('created_at', 'desc')->paginate(10);
        return view('masyarakat.notifikasi.index', compact('notifikasis'));
    }

    public function markAsRead(Notifikasi $notifikasi)
    {
        if ($notifikasi->user_id === auth()->id()) {
            $notifikasi->update(['is_read' => true]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    }

    public function markAllAsRead()
    {
        auth()->user()->notifikasis()->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function getUnreadCount()
    {
        $count = auth()->user()->notifikasis()->where('is_read', false)->count();
        return response()->json(['count' => $count]);
    }
}
