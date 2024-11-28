<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'nomor_pesanan',
        'nama_pemesan',
        'product_id',
        'quantity',
        'total_price',
        'status',
        'id_kategori_pesanan',
        'terima',
    ];
    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Produk::class);
    }

    public function kategoriPesanan()
    {
        return $this->belongsTo(KategoriPesanan::class, 'id_kategori_pesanan', 'id');
    }

    public function getImageUrlAttribute()
    {
        return $this->gambar 
            ? asset('storage/' . $this->gambar) 
            : null;
    }
}
