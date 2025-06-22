<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone_number' => '081234567890',
            'nik' => '1234567890123456',
        ]);

        $this->call([
            AdminUserSeeder::class, // Pastikan seeder admin sudah ada di sini
            KategoriLaporanSeeder::class, // Tambahkan baris ini
        ]);
    }
}
