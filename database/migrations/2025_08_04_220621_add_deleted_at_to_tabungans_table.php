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
        Schema::table('tabungans', function (Blueprint $table) {
            $table->softDeletes(); // Ini akan menambahkan kolom deleted_at
        });
    }

    public function down(): void
    {
        Schema::table('tabungans', function (Blueprint $table) {
            $table->dropSoftDeletes(); // Ini akan menghapus kolom deleted_at
        });
    }
};
