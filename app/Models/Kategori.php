<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;
    protected $fillable = [
        'id_kategori',
        'nama_kategori',
    ];

    public function buku()
    {
        return $this->hasMany(Buku::class, 'id_kategori', 'id_kategori');
    }
}
