<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    use HasFactory;
    protected $table = 'kategori_produk';

    protected $fillable = [
        'nama',
    ];

    /**
     * Relasi dengan model Produk (One to Many)
     */
    public function produk()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
}