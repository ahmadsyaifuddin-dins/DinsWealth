<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tabungan_images', function (Blueprint $table) {
            $table->id();
            // Foreign key yang terhubung ke tabel tabungans
            $table->foreignId('tabungan_id')
                  ->constrained('tabungans')
                  ->onDelete('cascade'); // PENTING: Jika data tabungan dihapus, gambar terkait juga akan terhapus dari tabel ini.
            $table->string('path'); // Path untuk menyimpan lokasi gambar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tabungan_images');
    }
};