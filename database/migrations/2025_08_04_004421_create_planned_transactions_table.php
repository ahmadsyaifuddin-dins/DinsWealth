<?php

// file: [timestamp]_create_planned_transactions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planned_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nama')->constrained('kategori_nama_tabungans');
            $table->foreignId('jenis')->constrained('kategori_jenis_tabungans');
            $table->decimal('nominal', 12, 2);
            $table->text('keterangan')->nullable();
            $table->date('jatuh_tempo');
            $table->datetime('tanggal_peristiwa')->nullable();
            $table->enum('status', ['pending', 'done'])->default('pending');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planned_transactions');
    }
};
