<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LampiranPengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengaduan_id',
        'file_path',
        'file_name_original',
        'file_mime_type',
        'file_size',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    public function getFileUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    public function isImage()
    {
        return Str::startsWith($this->file_mime_type, 'image/');
    }

    public function isVideo()
    {
        return Str::startsWith($this->file_mime_type, 'video/');
    }
}
