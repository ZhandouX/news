<!-- 
JALANKAN PERINTAH INI DI TERMINAL UNTUK MEMBUAT FILE MIGRASI INI
    ==> php artisan make:migration add_last_seen_to_users_table <== 
-->
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    // MIGRASI UNTUK MENAMBAHKAN COLOM last_seen (UNTUK FUNGSI MONITORING AKTIVITAS AKUN) KE TABEL USERS 
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('last_seen')->nullable()->after('remember_token');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_seen');
        });
    }
};
