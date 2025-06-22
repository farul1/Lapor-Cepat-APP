<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TanggapanPengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengaduan_id',
        'admin_id',
        'isi_tanggapan',
        'jenis_tanggapan',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
