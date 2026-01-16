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
        Schema::create('menus', function (Blueprint $table) {
            $table->id('id_menu');
            $table->foreignId('kategori_id')->constrained('kategoris', 'id_kategori')->onDelete('cascade');
            $table->string('nama_menu');
            $table->text('deskripsi')->nullable();
            $table->bigInteger('harga');
            $table->integer('stok');
            $table->string('foto')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
