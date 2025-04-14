<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_pinjem';
    public $timestamps = false;
    public $keyType = 'string';
    protected $fillable = [
        'id_pinjem',
        'id_buku', 
        'id_member',     
        'tgl_pinjam',
        'tgl_kembali',
    ];
    
    protected static function boot() 
    {
        parent::boot();
        static::creating(function ($peminjaman) {
           $lastpeminjaman = Peminjaman::orderBy('id_pinjem', 'desc')->first();
           $lastpeminjaman = $lastpeminjaman ? intval(substr($lastpeminjaman->id_pinjem, 2)) : 0;
           $peminjaman->id_pinjem = 'P' . str_pad($lastpeminjaman + 1, 4, '0', STR_PAD_LEFT);
        });  
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member', 'id_member');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }
    public function denda()
    {
        return $this->belongsTo(Denda::class, 'id_pinjem', 'id_pinjem');
    }
}
