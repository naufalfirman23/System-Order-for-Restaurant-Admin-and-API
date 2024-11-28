<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPesanan extends Model
{
    use HasFactory;
    protected $table = 'kategori_pesanan';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_kategori_pesanan');
    }
}
