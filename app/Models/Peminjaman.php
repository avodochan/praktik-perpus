<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_pinjem';
    public $timestamps = false;
    public $keyType = 'string';
    
    //field yang diisikan ke database
    protected $fillable = [
        'id_pinjem',
        'id_buku', 
        'id_member',     
        'tgl_pinjam',
        'tgl_kembali',
    ];
    
    //karena id_pinjem adalah string, untuk menambahkan id depannya menggunakan method ini
    protected static function boot() 
    {
        parent::boot();
        static::creating(function ($peminjaman) {
           $lastpeminjaman = Peminjaman::orderBy('id_pinjem', 'desc')->first();
           $lastpeminjaman = $lastpeminjaman ? intval(substr($lastpeminjaman->id_pinjem, 2)) : 0;
           $peminjaman->id_pinjem = 'P' . str_pad($lastpeminjaman + 1, 4, '0', STR_PAD_LEFT);
        });  
    }
    
    protected $appends = ['tgl_kembali_seharusnya', 'tgl_kembali_sebenarnya']; //agar muncul saat di looping

    // attribute untuk menampilkan data tanggall dengan format d-m-Y
    public function getTglPinjamFormattedAttribute()
    {
        return $this->attributes['tgl_pinjam'] ? Carbon::parse($this->attributes['tgl_pinjam'])->format('d-m-Y') : null;
    }

    public function getTglKembaliSeharusnyaAttribute()
    {
        return $this->attributes['tgl_pinjam'] ? Carbon::parse($this->attributes['tgl_pinjam'])->addDays(7)->format('d-m-Y') : null;
    }

    public function getTglKembaliSebenarnyaAttribute()
    {
        return $this->attributes['tgl_kembali'] ? Carbon::parse($this->attributes['tgl_kembali'])->format('d-m-Y') : null;
    }

    
    //relasi ke tabel lain
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
