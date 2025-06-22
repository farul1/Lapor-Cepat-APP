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
        Schema::create('lampiran_pengaduans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduan_id')->constrained('pengaduans')->onDelete('cascade');
            $table->string('file_path'); // Path penyimpanan file
            $table->string('file_name_original'); // Nama file asli saat diupload
            $table->string('file_mime_type'); // Tipe MIME file (image/jpeg, video/mp4)
            $table->unsignedBigInteger('file_size'); // Ukuran file dalam bytes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lampiran_pengaduans');
    }
};
