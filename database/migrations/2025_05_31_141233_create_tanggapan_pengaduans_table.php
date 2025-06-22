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
    Schema::create('tanggapan_pengaduans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pengaduan_id')->constrained('pengaduans')->onDelete('cascade');
        $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
        $table->text('isi_tanggapan');
        $table->enum('jenis_tanggapan', ['publik', 'internal'])->default('publik');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanggapan_pengaduans');
    }
};
