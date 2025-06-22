<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriLaporan; // Import model KategoriLaporan
use Illuminate\Support\Str; // Import Str untuk membuat slug

class KategoriLaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama untuk menghindari duplikat jika seeder dijalankan lagi
        KategoriLaporan::truncate();

        $kategoris = [
            [
                'nama_kategori' => 'Infrastruktur',
                'deskripsi' => 'Laporan terkait kerusakan jalan, jembatan, drainase, lampu jalan mati, dll.'
            ],
            [
                'nama_kategori' => 'Keamanan & Ketertiban',
                'deskripsi' => 'Laporan terkait gangguan kamtibmas, parkir liar, premanisme, dll.'
            ],
            [
                'nama_kategori' => 'Kesehatan',
                'deskripsi' => 'Laporan terkait layanan puskesmas/rumah sakit, permintaan fogging DBD, dll.'
            ],
            [
                'nama_kategori' => 'Lingkungan',
                'deskripsi' => 'Laporan terkait penumpukan sampah liar, banjir, polusi udara/air, pohon tumbang, dll.'
            ],
            [
                'nama_kategori' => 'Pelayanan Publik',
                'deskripsi' => 'Laporan terkait administrasi kependudukan yang lambat, masalah PDAM, keluhan listrik, dll.'
            ],
            [
                'nama_kategori' => 'Pendidikan',
                'deskripsi' => 'Laporan terkait masalah fasilitas sekolah negeri, pungutan liar, dll.'
            ],
            [
                'nama_kategori' => 'Sosial',
                'deskripsi' => 'Laporan terkait bantuan sosial yang tidak tepat sasaran, masalah sosial lainnya.'
            ],
        ];

        // Looping untuk memasukkan data ke database
        foreach ($kategoris as $kategori) {
            KategoriLaporan::create([
                'nama_kategori' => $kategori['nama_kategori'],
                'slug' => Str::slug($kategori['nama_kategori']), // Membuat slug otomatis dari nama kategori
                'deskripsi' => $kategori['deskripsi']
            ]);
        }
    }
}
