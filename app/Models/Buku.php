<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;
    protected $table = 'buku';
    protected $primaryKey = 'id_buku';
    public $timestamps = false;
    protected $fillable = [
        'id_buku',
        'id_kategori',
        'judul',
        'penulis',
        'penerbit',
        'stok',
        'cover',
        'sinopsis',
    ];
    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_buku', 'id_buku');
    }
}
