<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';

    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'kategori_id',
        'gambar',
    ];

    /**
     * Relasi dengan model KategoriProduk (Many to One)
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_id');
    }

    public function getImageUrlAttribute()
    {
        return $this->gambar 
            ? asset('storage/' . $this->gambar) 
            : null;
    }
    
}
