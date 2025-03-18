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
    protected $fillable = [
        'id_pinjem',
        'id_buku', 
        'id_member',     
        'tgl_pinjam',
        'tgl_kembali',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_pinjem', 'id_member');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }
}
