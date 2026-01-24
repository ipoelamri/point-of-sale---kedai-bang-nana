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
        Schema::table('orders', function (Blueprint $table) {
            // Tambah kolom no_meja jika belum ada
            if (!Schema::hasColumn('orders', 'no_meja')) {
                $table->string('no_meja')->nullable()->after('tipe_pesanan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'no_meja')) {
                $table->dropColumn('no_meja');
            }
        });
    }
};
