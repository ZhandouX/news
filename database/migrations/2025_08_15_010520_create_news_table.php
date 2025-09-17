<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // MIGRASI UNTUK MEMBUAT TABEL NEWS (TABEL BERITA)
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('cover_image')->nullable();
            $table->date('news_date');
            $table->text('content');
            $table->enum('category', [
                'Berita Daerah',
                'Berita Umum'
            ]);
            $table->string('office');
            $table->enum('sumber', [
                'Maluku Terkini',
                'RRI Ambon',
                'Tribun Ambon',
                'Siwa Lima',
                'Ambon Ekspres',
                'Teras Maluku',
                'Antara News Ambon',
                'Berita Satu'
            ]);
            $table->timestamps(); // created_at adalah tanggal tambahkan berita

            // Unique constraint untuk mencegah duplikat judul + tanggal
            $table->unique(['title', 'news_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
