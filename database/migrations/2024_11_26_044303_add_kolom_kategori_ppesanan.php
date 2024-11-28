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
            $table->foreignId('id_kategori_pesanan')
                  ->nullable() // Kolom dapat bernilai null (jika tidak langsung diisi)
                  ->after('status') // Letakkan setelah kolom `status`
                  ->constrained('kategori_pesanan') // Relasi ke tabel `kategori_pesanan`
                  ->onDelete('cascade'); // Hapus order jika kategori pesanan terkait dihapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['id_kategori_pesanan']); // Hapus foreign key
            $table->dropColumn('id_kategori_pesanan'); // Hapus kolom
        });
    }
};
