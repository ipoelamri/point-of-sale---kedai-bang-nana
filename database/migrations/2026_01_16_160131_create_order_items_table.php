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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('id_item');
            $table->foreignId('order_id')->constrained('orders', 'id_order')->onDelete('cascade');
            $table->foreignId('menu_id')->constrained('menus', 'id_menu');
            $table->integer('jumlah');
            $table->bigInteger('harga_satuan');
            $table->bigInteger('subtotal');
            $table->text('catatan_khusus')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
