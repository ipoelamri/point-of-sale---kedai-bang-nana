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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->foreignId('order_id')->constrained('orders', 'id_order')->onDelete('cascade');
            $table->string('snap_token')->nullable();
            $table->string('metode_bayar')->nullable(); // gopay, qris, dll
            $table->string('status_bayar')->default('pending');
            $table->text('midtrans_log')->nullable();
            $table->dateTime('waktu_bayar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
