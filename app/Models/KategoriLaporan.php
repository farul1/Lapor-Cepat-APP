<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Tambahkan ini

class KategoriLaporan extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kategori', 'slug', 'deskripsi'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kategori) {
            $kategori->slug = Str::slug($kategori->nama_kategori);
        });

        static::updating(function ($kategori) {
            $kategori->slug = Str::slug($kategori->nama_kategori);
        });
    }

    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class, 'kategori_id');
    }
}
