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
    public $keyType = 'string';
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
    
    protected static function boot() 
    {
        parent::boot();
        static::creating(function ($buku) {
           $lastbuku = Buku::orderBy('id_buku', 'desc')->first();
           $lastbuku = $lastbuku ? intval(substr($lastbuku->id_buku, 2)) : 0;
           $buku->id_buku = 'B' . str_pad($lastbuku + 1, 4, '0', STR_PAD_LEFT);
        });  
    }
    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_buku', 'id_buku');
    }
}
