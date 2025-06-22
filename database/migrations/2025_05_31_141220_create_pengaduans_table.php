<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('isi_laporan');
            $table->foreignId('kategori_id')->nullable()->constrained('kategori_laporans')->onDelete('set null');
            $table->date('tanggal_kejadian')->nullable();
            $table->string('lokasi_text');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->enum('status', ['menunggu_verifikasi', 'diterima', 'diproses', 'selesai', 'ditolak'])->default('menunggu_verifikasi');
            $table->text('alasan_ditolak')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
