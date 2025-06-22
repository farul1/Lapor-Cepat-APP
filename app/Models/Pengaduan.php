<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'judul',
        'slug',
        'isi_laporan',
        'kategori_id',
        'tanggal_kejadian',
        'lokasi_text',
        'latitude',
        'longitude',
        'status',
        'alasan_ditolak',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pengaduan) {
            $pengaduan->slug = Str::slug($pengaduan->judul . '-' . time());
        });

        static::updating(function ($pengaduan) {
            if ($pengaduan->isDirty('judul')) {
                $pengaduan->slug = Str::slug($pengaduan->judul . '-' . time());
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriLaporan::class, 'kategori_id');
    }

    public function lampirans()
    {
        return $this->hasMany(LampiranPengaduan::class);
    }

    public function tanggapans()
    {
        return $this->hasMany(TanggapanPengaduan::class);
    }

    public function notifikasis()
    {
        return $this->hasMany(Notifikasi::class);
    }
}
