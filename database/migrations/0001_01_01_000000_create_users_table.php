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
        Schema::create('users', function (Blueprint $table) {
            // 1. Sesuai Tabel 3.1 No.1: id_user
            $table->id('id_user');

            // 2. Sesuai Tabel 3.1 No.2: username
            $table->string('username', 50)->unique();

            // 3. Sesuai Tabel 3.1 No.3: password
            $table->string('password');

            // 4. Sesuai Tabel 3.1 No.4: role (admin/kasir/pemilik/pelanggan)
            $table->string('role', 20)->default('pelanggan');

            // 5. Sesuai Tabel 3.1 No.5: created_at (timestamps otomatis bikin created_at & updated_at)
            $table->timestamps();
        });

        // Tabel bawaan Laravel ini (reset password & sessions) BIARKAN SAJA,
        // tidak perlu dihapus karena berguna untuk sistem login nanti.
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
