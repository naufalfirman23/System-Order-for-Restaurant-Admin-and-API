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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi dengan pengguna
            $table->foreignId('product_id')->constrained('produk')->onDelete('cascade'); // Relasi dengan produk (menggunakan nama tabel 'produk')
            $table->integer('quantity'); // Jumlah produk yang dipesan
            $table->decimal('total_price', 8, 2); // Total harga
            $table->enum('status', ['pending', 'completed', 'canceled'])->default('pending'); // Status pesanan
            $table->timestamps();
        });
        
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
