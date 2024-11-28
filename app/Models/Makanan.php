<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Makanan extends Model
{
    use HasFactory;
    protected $table = 'makanan';

    // Tentukan kolom mana saja yang bisa diisi (mass assignable)
    protected $fillable = [
        'nama', 
        'harga', 
        'deskripsi'
    ];

}
