<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pengaduan_id',
        'judul_notifikasi',
        'pesan_notifikasi',
        'link_aksi',
        'is_read',
    ];

    // Relasi: Notifikasi dimiliki oleh satu User (penerima)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Notifikasi bisa terkait dengan satu Pengaduan
    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }
}
