<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Ini adalah metode yang akan dijalankan saat kamu menjalankan `php artisan migrate`.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom 'username' bertipe string dengan batasan unik
            // Kolom ini akan diletakkan setelah kolom 'email'
            $table->string('username')->unique()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * Ini adalah metode yang akan dijalankan saat kamu menjalankan `php artisan migrate:rollback`.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom 'username'
            $table->dropColumn('username');
        });
    }
};