<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id(); // Kolom ID (auto increment)
            $table->string('nama', 150); // Kolom nama produk
            $table->text('deskripsi')->nullable(); // Kolom deskripsi (opsional)
            $table->decimal('harga', 10, 2); // Kolom harga dengan skala 2 desimal
            $table->foreignId('kategori_id')->constrained('kategori_produk')->onDelete('cascade'); // Foreign key ke tabel kategori_produk
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
