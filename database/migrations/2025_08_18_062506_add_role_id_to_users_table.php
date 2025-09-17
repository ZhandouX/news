<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // MIGRASI UNTUK MENAMBAHKAN KOLOM role_id PADA TABEL USER
    // CATATAN:
               // HARUS DIBUAT SEBELUM MEMBUAT MIGRASI UNTUK add_user_id_to_news_table AGAR MENGHINDARI ERROR FOREIGN KEY NOT DEFINED
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role_id')) {
                $table->unsignedBigInteger('role_id')->nullable()->after('password');
                $table->foreign('role_id')->references('id')->on('roles')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }
};
